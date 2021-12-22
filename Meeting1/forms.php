<!doctype html />
<html>
<head>
	<title>PHP-forms</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

<h1>Работа с формами</h1>

<form method="get" action="/forms.php">
	<span>Введите число: </span>
	<input type="number" name="num" />
	<input type="submit" value="Ввести" />
</form>

<h2>Глобальные массивы</h2>
<p>
	При наличие данных формы, они собираются в глобальные
	массивы: $_GET - данные из строки запроса [FromQuery],
	$_POST - данные из тела запроса, 
	$_REQUEST - объединение двух предыдущих массивов.
	Ключи массивов - имена полей формы.
</p>

<?php
echo ( isset( $_GET[ 'num' ] ) ) 
	 ? "Yes, num={$_GET[ 'num' ]}" 
	 : "No" ;
echo "<br/>";

echo "GET: " ;    print_r( $_GET ) ;     echo "<br/>" ;
echo "POST:" ;    print_r( $_POST ) ;    echo "<br/>" ;
echo "REQUEST:" ; print_r( $_REQUEST ) ; echo "<br/>" ;
?>

</body>
</html>