<!doctype html />
<html>

<head>
	<meta charset="utf-8" />
	<title>Галерея</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<style>
		@font-face {
			font-family: "Brush";
			src: url("css/FK.ttf") format("truetype");
			font-style: normal;
		}



		.content {
			padding-bottom: 100px;
			display: flex;
			flex-direction: column;
			align-items: center;

		}

		.pageNumber {
			width: 10px;
			display: flex;
			align-items: center;
			flex-direction: column;
			color: white;
			font-size: 4vh;
			text-shadow: black 1px 1px 0, black -1px -1px 0,
				black -1px 1px 0, black 1px -1px 0;
			padding: 0px 0px 0px 0px;
			margin-left: 25px;
			margin-right: 25px;
		}

		.date {
			font-family: 'Courier New', Courier, monospace;
			font-size: 1em;
		}

		uploader {
			border: 1px solid #ccc;
			box-shadow: 5px 5px 2px #aaa;
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			display: flex;
			align-items: center;
			justify-self: flex-start;
			flex-direction: column;
			margin-left: 5px;
			margin-right: 5px;
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
			justify-content: space-evenly;
		}

		gallery .picture {
			box-shadow: 5px 5px 2px #aaa;
			display: flex;
			flex-direction: column;
			align-items: center;
			width: fit-content;
			height: fit-content;
			max-width: 25vh;
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			flex-direction: column;
			margin: 1vw;
			padding: 1vw;
		}

		gallery .picture img {
			width: fit-content;
			max-width: 20vh;
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
			margin-left: 5px;
			margin-right: 5px;
			flex-direction: row;
			align-items: center;
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			padding: 3px;
			height: fit-content;
			justify-self: flex-end;
			align-self: flex-end;
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

		paginator button {
			font-size: 2.5vh;
		}

		button {
			border: 2px solid burlywood;
			border-radius: 5px;
			background-color: wheat;
			align-items: center;
			display: flex;
			flex-direction: row;
			align-items: center;
			height: fit-content;
			align-self: center;
			padding: 5px;
			text-align: center;
		}

		.filterBTN {
			width: 70px;
		}

		button:hover {
			background-color: burlywood;
		}

		button:disabled:hover {
			background-color: wheat;
		}

		button:disabled {
			opacity: 0.7;
		}

		input[type="date"] {
			background-color: #ffeaa7;
			border: 1px solid #fdcb6e;
			border-radius: 4px;
			display: flex;
			flex-direction: row;
			align-content: space-around;
			text-align: center;
			padding: 10px 0px 10px 0px;
		}

		input {
			background-color: #ffeaa7;
			border: 1px solid #fdcb6e;
			margin-bottom: 5px;
			padding: 5px;
		}

		h1 {
			color: whitesmoke;
			font-family: "Brush";
			margin: 0px;
			font-size: 10vh;

			text-shadow: #2C3E50 1px 1px 0, #2C3E50 -1px -1px 0,
				#2C3E50 -1px 1px 0, #2C3E50 1px -1px 0;
		}

		select {
			background: transparent;
			border: 2px solid burlywood;
			border-radius: 3px;
			padding: 5px;
		}

		option {
			background-color: #fdcb6e;
			border: 1px solid #ffeaa7;
		}


		select:hover {
			background-color: #b2bec3;
		}

		.ui {
			display: flex;
			align-items: center;
			justify-content: space-between;
			flex-direction: row;
			width: 100%;
			margin-left: 10px;
			margin-right: 10px;
			margin-bottom: 20px;
			height: min-content;
			flex-wrap: wrap;
		}

		.row {
			display: flex;
			flex-direction: row;
		}

		.col {
			display: flex;
			align-items: center;
			flex-direction: column;
		}
	</style>
</head>

<body>
	<div class="content">
		<h1>Галерея</h1>

		<div class="ui">
			<uploader>
				<input type="file" name="pictureFile" />
				<br />
				<input name="pictureDescriptionUk" value="Ця найкраща" />
				<input name="pictureDescriptionEn" value="The best one" />
				<input name="pictureDescriptionRu" value="Это самая лучшая" />
				<button name="addPicture">Добавить</button>
			</uploader>



			<div class="container">
				<div class="col">
					<p style="margin: 0px;">Filters</p>

					<div class="row">
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

				</div>

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