<!doctype html />
<html>

<head>
	<meta charset="utf-8" />
	<title>PHP API</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<style>
		body {
			display: flex;
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
		}

		hr {
			position: absolute;
			text-align: center;
			left: 0;
			bottom: 0;
			width: 99.9%;
			height: 80px;
		}

		footer {
			position: absolute;
			text-align: center;
			left: 0;
			bottom: 0;
			width: 99.9%;
			height: 80px;
		}
	</style>
</head>

<body>
	<h1>Панель диагностики API</h1>

	<div>
		<button id="testGetButton">GET</button>
		<button id="testPostButton">POST</button>
		<button id="testPutButton">PUT</button>
		<button id="testDeleteButton">DELETE</button>
	</div>


	<div>
		<input type="file" name="userFile" />
		<button id="filePostButton">POST</button>
	</div>

	<div>
		<button id="localeUaButton">Locale: Ua</button>
		<button id="localeEnButton">Locale: En</button>
		<button id="localeRuButton">Locale: Ru</button>
	</div>

	<div>
		<form action="/gallery" target="_blank">
			<button>Gallery</button>
		</form>
	</div>

	<p id=out></p>

	<hr />
	<footer>

		<?php
		echo "&copy; ITSTEP, КН-П-181, 2018 - "
			. date("Y")
			. "<br/>";
		print_r($_GET);
		?>
	</footer>
	<script src="index.js"></script>
</body>

</html>