document.addEventListener("DOMContentLoaded", function(){
	const uploader = document.querySelector("uploader");
	if(!uploader) throw "uploader-container not found";
	
	const addPictureButton = uploader.querySelector("[name=addPicture]");
	if(!addPictureButton) throw "addPicture button not found";
	addPictureButton.addEventListener("click", addPictureClick);
	
	loadGallery();
	initPaginator();
	initFilter();
	initLangSwitch();
});
function initLangSwitch() {
	const langSwitch = document.getElementById("langSwitch");
	const langSelect = document.getElementById("langSelect");
	const setLang = document.getElementById("setLang");
	if(!langSwitch || !langSelect || !setLang)
		throw "initLangSwitch - element(s) location error";
	fetch("/api/gallery?langs").then(r=>r.json())
	.then(j => {
		j.push("all");
		for(let lang of j) {
			let opt = document.createElement("option");
			opt.value = lang;
			opt.innerText = lang;
			langSelect.appendChild(opt);
		}
		
		setLang.onclick = langChange;
	});
}
function langChange() {
	const opt = document.querySelector("#langSelect option:checked");
	if(!opt) {
		alert("Select lang before switching");
		return;
	}
	loadGallery({'lang': opt.value});
}

function initFilter() {
	const applyFilter = document.querySelector("#applyFilter");
	if(!applyFilter) throw "applyFilter button not found";
	applyFilter.addEventListener("click", applyFilterClick);
}
function applyFilterClick() {
	const datePicker = document.querySelector("#datePicker");
	if(!datePicker) throw "datePicker button not found";
	const date = datePicker.value;
	if(date.length == 0) {
		alert("Select date to filter");
		return;
	}
	loadGallery({'date': date});
}

function initPaginator() {
	const prevButton = document.querySelector("#prevPage");
	if(!prevButton) throw "prevButton button not found";
	prevButton.addEventListener("click", prevButtonClick);
	const nextButton = document.querySelector("#nextPage");
	if(!nextButton) throw "nextButton button not found";
	nextButton.addEventListener("click", nextButtonClick);
	
}
function prevButtonClick(e) {
	const cont = document.querySelector("gallery");
	if(!cont) throw "Gallery container not found";
	var currentPage = cont.getAttribute("pageNumber");
	currentPage--;
	loadGallery({page: currentPage});
}
function nextButtonClick(e) {
	const cont = document.querySelector("gallery");
	if(!cont) throw "Gallery container not found";
	var currentPage = cont.getAttribute("pageNumber");
	currentPage++;
	loadGallery({page: currentPage});
}

function addPictureClick(e) {
	const picFile = e.target.parentNode.querySelector("[name=pictureFile]");
	if(!picFile) throw "pictureFile not found";

	if(picFile.files.length == 0){
		alert("Выберите файл");
		return;
	}	
	const fd = new FormData();
	fd.append("pictureFile", picFile.files[0]);
	
	for( let elem of [
		"pictureDescriptionUk",
		"pictureDescriptionEn",
		"pictureDescriptionRu"
		] ) {
			var picDescr = e.target.parentNode.querySelector(`[name=${elem}]`);
			if(!picDescr) throw `${elem} not found`;
			// console.log(picDescr.value);
			fd.append(elem, picDescr.value);
		}
// console.log(fd); return ;
		
	fetch("/api/gallery",{
		method: "post",
		headers: {
			
		},
		body: fd
	})
	.then(r=>r.text())
	.then(console.log)
}

function loadGallery(params) {
	var queryString = "";
	if(typeof params == 'object'){
		delimiter = '?';
		for(let prop in params) {
			queryString += delimiter + prop + "=" + params[prop];
			delimiter = '&';
		}
	}
	
	fetch("/api/gallery" + queryString)
	.then(r=>r.text())
	.then(showGallery);
}

function showGallery(t) {
	const cont = document.querySelector("gallery");
	if(!cont) throw "Gallery container not found";
	try {
		var j = JSON.parse(t);
// console.log(j);return;
		if(j.warn.length != 0){  // show warnings if exist
			console.log(j.warn);
		}
	} 
	catch {
		console.log("JSON parse error");
		console.log(t);
		return;
	}
	const picTpl = `
		<div class='picture'>
			<img src='/pictures/{{filename}}' />
			<b>{{moment}}</b>
			<p>{{descr}}</p>
		</div>
	`;
	var contHTML = "";
	for(let picId in j.data) {
// console.log(picId, j.data[picId]); continue;
		var descr = "";
		for(let lang in j.data[picId].descr){
			descr += lang + ':' + j.data[picId].descr[lang] + '<br/>' ;
		}
		contHTML += picTpl
			.replace( "{{filename}}", j.data[picId].filename)
			.replace( "{{moment}}", j.data[picId].moment)
			.replace( "{{descr}}", descr);
	}
	cont.innerHTML = contHTML;
	cont.setAttribute("pageNumber", j.meta.page);
}
