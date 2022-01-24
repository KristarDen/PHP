<!doctype html />
<html>

<head>
	<meta charset="utf-8" />
	<title>Галерея</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<style>
		.content {
			padding-bottom: 100px;
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.pageNumber{
			width: 10px;
			display: flex;
			align-items:center ;
			flex-direction: column;
			color: white;
			font-size: 4vh;
			text-shadow: black 1px 1px 0, black -1px -1px 0,
				black -1px 1px 0, black 1px -1px 0;
			padding: 0px 0px 0px 0px;
			margin-left: 25px;
			margin-right: 25px;
		}
		.date{
			font-family: 'Courier New', Courier, monospace;
			font-size:  1em;
		}

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

		input {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		gallery {
			display: flex;
			align-items: stretch;
			flex-wrap: wrap;
			justify-content: space-around;
		}

		gallery .picture {
			box-shadow: 5px 5px 2px #aaa;
			display: flex;
			flex-direction: column;
			align-items: center;
			width: max-content;
			height: fit-content;
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			flex-direction: column;
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
			position: relative;
  			min-height: 100%;
			background-image: url("Red_brick_wall_texture.jpeg");
			background-size: cover;
			background-repeat: no-repeat;
			
		}

		.container {
			display: flex;
			margin: 5px;
			flex-direction: row;
			align-items: center;
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			padding: 3px;
		}

		

		hr {
			position: absolute;
			text-align: center;
			left: 0;
			bottom: 10px;
			width: 99.9%;
		}

		footer {
			color: #ccc;
			height: 30px;
			position: absolute;
			padding-top: 5px;
			flex-direction: row;
			align-items: center;
			text-align: center;
			bottom: 0;
			text-shadow: black 1px 1px 0, black -1px -1px 0,
				black -1px 1px 0, black 1px -1px 0;
		}

		.info {
			display: flex;
			flex-direction: column;
		}

		.descr {
			display: flex;
			flex-direction: column;
			width: 100%;
		}

		paginator {
			display: flex;
			flex-direction: row;
			align-items: center;
			
		}
		paginator button{
			font-size: 2.5vh;
		}

		button {
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			align-items: center;
			display: flex;
			height: fit-content;
			align-self: center;
		}
		.filterBTN{
			width: 70px;
		}

		button:hover {
			background-color: burlywood;
		}
		button:disabled:hover{
			background-color: wheat;
		}
		button:disabled{
			opacity: 0.7;
		}

		h1 {
			color: white;
			font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
			font-size: 7vh;
			text-shadow: black 1px 1px 0, black -1px -1px 0,
				black -1px 1px 0, black 1px -1px 0;
		}
	</style>
</head>

<body>
	<div class="content">
		<h1>Галерея</h1>

		<uploader>
			<input type="file" name="pictureFile" />
			<br />
			<input name="pictureDescriptionUk" value="Ця найкраща" />
			<input name="pictureDescriptionEn" value="The best one" />
			<input name="pictureDescriptionRu" value="Это самая лучшая" />
			<button name="addPicture">Добавить</button>
		</uploader>



		<div class="container">
			<div id="dataFilter" class="container">
				<input type="date" id="datePicker" />
				<br />
				<div style="display: flex; flex-direction: column; align-items: stretch;">
					<button class="filterBTN" id="applyFilter">Filter</button>
					<button class="filterBTN" id="cancelFilter">NoFilter</button>
				</div>
				
			</div>

			<div id="langSwitch" class="container">
				<select id="langSelect"></select>
				<button id="setLang">Set</button>
			</div>

		</div>

		<gallery></gallery>

		<paginator>
			<button id="prevPage">Prev</button>
			<div id="currPage" class="pageNumber"></div>
			<button id="nextPage">Next</button>
		</paginator>


	</div>
	<footer>

		<?php
		echo "&copy; ITSTEP, КН-П-181, 2018 - " . date("Y");
		?>
	</footer>

	<script src="gallery.js"></script>
</body>

</html>