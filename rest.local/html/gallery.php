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
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			display: flex;
			align-items: center;
			flex-direction: column;
			margin: 5px;
			padding: 5px;
		}

		gallery {
			display: flex;
		}

		gallery .picture {
			border: 1px solid salmon;
			box-shadow: 5px 5px 2px #aaa;
			display: flex;
			flex-direction: row;
			margin: 1vw;
			padding: 1vw;
		}

		gallery .picture img {
			max-width: 20vw;
		}

		gallery .picture b {
			display: block;
		}

		body {
			display: flex;
			background-image: url("Red_brick_wall_texture.jpeg");
			background-size: cover;
			background-repeat: no-repeat;
			flex-direction: column;
			align-items: center;
		}

		div {
			display: flex;
			margin: 5px;
			flex-direction: row;
			align-items: center;
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			padding: 3px;
		}

		button {
			display: flex;
			margin: 5px;
			width: fit-content;
		}

		hr {
			position: absolute;
			text-align: center;
			left: 0;
			bottom: 10px;
			width: 99.9%;
		}

		footer {
			position: absolute;
			text-align: center;
			left: 0;
			bottom: 0;
			width: 99.9%;
			height: fit-content;
			background-color: brown;
		}

		.info {
			display: flex;
			flex-direction: column;
		}
		.descr{
			display: flex;
			flex-direction: column;
		}
		paginator{
			display: flex;
			flex-direction: row;
		}
		
	</style>
</head>

<body>
	<h1>Галерея</h1>

	<uploader>
		<input type="file" name="pictureFile" />
		<br />
		<input name="pictureDescriptionUk" value="Ця найкраща" />
		<input name="pictureDescriptionEn" value="The best one" />
		<input name="pictureDescriptionRu" value="Это самая лучшая" />
		<button name="addPicture">Добавить</button>
	</uploader>

	

	<div>
	<div id="dataFilter">
		<input type="date" id="datePicker" />
		<br />
		<button id="applyFilter">Filter</button>
	</div>

	<div id="langSwitch">
		<select id="langSelect"></select>
		<button id="setLang">Set</button>
	</div>

	</div>
	
	<gallery></gallery>

	<paginator>
		<button id="prevPage">Prev</button>
		<button id="nextPage">Next</button>
	</paginator>

	
	<hr />
	<footer>

		<?php
		echo "&copy; ITSTEP, КН-П-181, 2018 - " . date("Y");
		?>
	</footer>

	<script src="gallery.js"></script>
</body>

</html>