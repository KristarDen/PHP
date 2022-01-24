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
var Is_Filter_Set = false; //date filter switcher

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
	let currentPage = parseInt(document.getElementById("currPage").innerHTML);
	loadGallery({'lang': opt.value, page : currentPage});
}

function initFilter() {
	const applyFilter = document.querySelector("#applyFilter");
	const cancelFilter = document.querySelector("#cancelFilter");
	if(!applyFilter) throw "applyFilter button not found";
	if(!cancelFilter) throw "cancelFilter button not found";

	applyFilter.addEventListener("click", applyFilterClick);
	cancelFilter.addEventListener("click", cancelFilterClick);
}
function applyFilterClick() {
	const datePicker = document.querySelector("#datePicker");
	if(!datePicker) throw "datePicker button not found";
	const date = datePicker.value;
	if(date.length == 0) {
		alert("Select date to filter");
		return;
	}
	Is_Filter_Set = true;
	let currentPage = parseInt(document.getElementById("currPage").innerHTML);
	loadGallery({'date': date, page : currentPage});
}
function cancelFilterClick() {
	Is_Filter_Set = false;
	let currentPage = parseInt(document.getElementById("currPage").innerHTML);
	loadGallery({page : currentPage});
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

	const opt = document.querySelector("#langSelect option:checked");
	const datePicker = document.querySelector("#datePicker");
	const date = datePicker.value;
	if(Is_Filter_Set == true){
		loadGallery({'date': date,'lang': opt.value, page : currentPage});
	} else{
		loadGallery({'lang': opt.value, page : currentPage});
	}
}
function nextButtonClick(e) {
	const cont = document.querySelector("gallery");
	if(!cont) throw "Gallery container not found";

	var currentPage = cont.getAttribute("pageNumber");
	currentPage++;

	const opt = document.querySelector("#langSelect option:checked");
	const datePicker = document.querySelector("#datePicker");
	const date = datePicker.value;
	if(Is_Filter_Set == true){
		loadGallery({'date': date,'lang': opt.value, page : currentPage});
	} else{
		loadGallery({'lang': opt.value, page : currentPage});
	}
	
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
			fd.append(elem, picDescr.value);
		}
		
	fetch("/api/gallery",{
		method: "post",
		headers: {
			
		},
		body: fd
	})
	.then(r=>r.text())
	.then(console.log);

	let currentPage = parseInt(document.getElementById("currPage").innerHTML);
	loadGallery({page: currentPage});
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
	document.getElementById("nextPage").disabled = false;
	document.getElementById("prevPage").disabled = false;
	if(!cont) throw "Gallery container not found";
	try {
		var j = JSON.parse(t);
		if(j.warn.length != 0){ 
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
			<div class="info"><img src='/pictures/{{filename}}'/><b class="date">{{moment}}</b></div>
			<div class="descr"><p>{{descr}}</p></div>
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
	document.getElementById("currPage").innerHTML = "" + j.meta.page;
	if( j.meta.page == j.meta.lastPage){
		document.getElementById("nextPage").disabled = true;
	}
	if( j.meta.page == 1){
		document.getElementById("prevPage").disabled = true;
	}
}
