<!doctype html />
<html>
<head>
	<meta charset="utf-8" />
	<title>Галерея</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<style>
	uploader {
		border: 1px solid #ccc;
		box-shadow: 5px 5px 2px #aaa;
		display: inline-block;
		margin: 5px;
		padding: 5px;
	}
	</style>
</head>
<body>
<h1>Галерея</h1>

<uploader>
	<input type="file" name="pictureFile" />
	<br/>
	<textarea name="pictureDescription">
		Это самая лучшая
	</textarea>
	<button name="addPicture">Добавить</button>
</uploader>

<footer>
<hr/>
<?php
	echo "&copy; ITSTEP, КН-П-181, 2018 - " . date( "Y" ) ;
?>
</footer>

<script src="gallery.js"></script>
</body>
</html>