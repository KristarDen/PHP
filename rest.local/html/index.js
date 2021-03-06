document.addEventListener("DOMContentLoaded", function(){
	const testGetButton = document.getElementById("testGetButton");
	if(!testGetButton) throw "testGetButton not found";
	else testGetButton.onclick = testGet;
	
	const testPostButton = document.getElementById("testPostButton");
	if(!testPostButton) throw "testPostButton not found";
	else testPostButton.onclick = testPost;
	
	const testPutButton = document.getElementById("testPutButton");
	if(!testPutButton) throw "testPutButton not found";
	else testPutButton.onclick = testPut;
	
	const testDeleteButton = document.getElementById("testDeleteButton");
	if(!testDeleteButton) throw "testDeleteButton not found";
	else testDeleteButton.onclick = testDelete;

	const filePostButton = document.getElementById("filePostButton");
	if(!filePostButton) throw "filePostButton not found";
	else filePostButton.onclick = filePost;
	
	const localeUaButton = document.getElementById("localeUaButton");
	if(!localeUaButton) throw "localeUaButton not found";
	else localeUaButton.onclick = localeUaButtonClick;
	
	const localeEnButton = document.getElementById("localeEnButton");
	if(!localeEnButton) throw "localeEnButton not found";
	else localeEnButton.onclick = localeEnButtonClick;
});

function localeEnButtonClick() {
	fetch("/api/locale",{
		method: "get",
		headers: {
			"Locale": "en"
		}
	})
	.then(r=>r.text())
	.then(t=>{
		out.innerHTML = t;
	});
}

function localeUaButtonClick() {
	fetch("/api/locale",{
		method: "get",
		headers: {
			"Locale": "ua"
		}
	})
	.then(r=>r.text())
	.then(t=>{
		out.innerHTML = t;
	});
}

function testGet() {
	const out = document.getElementById("out");
	if(!out) throw "out not found";
	
	fetch("/api?x=11&y=21")
	.then(r=>r.text())
	.then(t=>{
		out.innerText = t;
	});
}

function testPost() {
	const out = document.getElementById("out");
	if(!out) throw "out not found";
	
	fetch("/api", {
		method: "post",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify( {
			"x": 10,
			"y": 20
		})
	})
	.then(r=>r.text())
	.then(t=>{
		out.innerText = t;
	}); 
	/*
	fetch("/api", {
		method: "post",
		headers: {
			"Content-Type": "application/x-www-form-urlencoded"
		},
		body: "x=10&y=20"
	})
	.then(r=>r.text())
	.then(t=>{
		out.innerText = t;
	});*/
}

function testPut() {
	const out = document.getElementById("out");
	if(!out) throw "out not found";
	
	fetch("/api", {
		method: "put",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify( {
			"x": 15,
			"y": 25
		})
	})
	.then(r=>r.text())
	.then(t=>{
		out.innerText = t;
	});
}

function testDelete() {
	const out = document.getElementById("out");
	if(!out) throw "out not found";
	
	fetch("/api", {
		method: "delete",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify( {
			"x": 16,
			"y": 26
		})
	})
	.then(r=>r.text())
	.then(t=>{
		out.innerText = t;
	});
}

function filePost() {
	const fileInput = document.querySelector("input[name=userFile]");
	if(!fileInput) throw "input[name=userFile] not found";
	if(fileInput.files.length == 0){
		alert("Select a file");
		return;
	}
	const fd = new FormData();
	fd.append("userFile", fileInput.files[0]);
	fetch("/api/file", {
		method: "post",
		body: fd
	}).then(r=>r.text()).then(t=>{
		const out = document.getElementById("out");
		if(!out) throw "out not found";	
		out.innerHTML = t;
	});
}