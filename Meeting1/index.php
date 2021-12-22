
<a href="/forms.php">Работа с формами</a>
<br/>
Вывести числа от 1 до 10:<br/>
<?php
$x = 10;
for( $i = 1; $i <= $x; $i++ ) {
	echo "<b>$i</b> ";
}
?>
<br/>Вариант 2:<br/>
<?php
for( $i = 1; $i <= $x; $i++ ) { ?> 
	<b>
	 <?= $i ?>
	</b> 
<?php } ?>
<br/>Вариант 3:<br/>
<?php
for( $i = 1; $i <= $x; $i++ ) : ?> 
	<b>
	 <?= $i ?>
	</b>
<?php endfor; ?>

<br/>
<?php
$arr1 = array() ;
$arr2 = [
	 1   => "One",
	"2"  => "two",
	"ar" => [ 1, 2, 3, 4 ]
] ;

$arr1[] = "Hello" ;
$arr1[] = "World" ;
$arr1[] = 2;

$arr1[4] = "4" ;
$arr1[-4] = "-4" ;
$arr1["index"] = "the index" ;

echo $arr2[2] . " " . $arr2["2"], "<br/>" ;

$arr2[] = [ "newindex" => "new value" ] ;

echo json_encode( $arr2 ), "<br/><br/>" ;

// echo "<pre>" ; print_r( $arr1 ) ; print_r( $arr2 ) ; 

foreach( $arr2 as $val ) {
	if( is_array( $val ) ) {
		print_r( $val ) ;
		echo "<br/>" ;
	} else {
		echo $val, "<br/>" ;
	}	
}

foreach( $arr2 as $key => $val ) :

	echo "$key => " ;
	
	if( is_array( $val ) ) {
		print_r( $val ) ;
		echo "<br/>" ;
	} else {
		echo "$val <br/>" ;
	}	
endforeach ;



 