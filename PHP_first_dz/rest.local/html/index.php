<!doctype html />
<html>
<head>
	<meta charset="utf-8" />
	<title>PHP API</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
</head>
<body>
<h1>Панель диагностики API</h1>

<button id="testGetButton">GET</button>
<button id="testPostButton">POST</button>
<button id="testPutButton">PUT</button>
<button id="testDeleteButton">DELETE</button>

<div style="border: 1px solid salmon; margin: 2vh 0; padding: 1vw 2vw">
	<input type="file" name="userFile" />
	<button id="filePostButton">POST</button>
</div>

<p id=out></p>

<hr/>
<footer>
<?php
	echo "&copy; ITSTEP, КН-П-181, 2018 - " 
		. date( "Y" ) 
		. "<br/>" ;
	print_r( $_GET ) ;
?>
</footer>
<script src="index.js"></script>
</body>
</html>