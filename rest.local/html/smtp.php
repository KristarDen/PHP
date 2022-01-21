<?php
/*
in php.ini (if not XAMPP): 
uncomment   ;extension=openssl
or add      extension=php_openssl.dll
*/
echo "<h1>SMTP - Simple Mail Transfer Protocol</h1>" ;

/////////////  INI PART ////////////////
$smtp_prot = "ssl" ;
$smtp_host = "smtp.ukr.net" ;
$smtp_port = "465" ;
$smtp_box  = "testunych@ukr.net" ; 
$smtp_user = base64_encode( $smtp_box ) ;
$smtp_pass = base64_encode( "eFIzkFbaMh5NplIm" ) ;
$smtp_context = [
	'ssl' => [
		'verify_peer'      => false, 
		'verify_peer_name' => false
	] ] ;
	
function ansread( $socket ) {   // Получение ответа из сокета 
  $ret = "" ;
  while( $str = fgets( $socket, 254 ) ) {
    $ret .= $str . "<br/>" ;
    if( substr( $str, 3, 1 ) == " " )  break ; 
  }
  return $ret ;
}

/////////////////// WORKING PART /////////////////	
// Создаем сетевое подключение - сокет
$stc = stream_context_create( $smtp_context ) ;
$s   = stream_socket_client(
		$smtp_prot
			. "://"
			. $smtp_host
			. ":"
			. $smtp_port,
		$errno, 
		$errstr,
		10,
		STREAM_CLIENT_CONNECT,
		$stc ) ;
// Проверяем успешность открытия сокета		
if( ! $s ) {
	echo $errstr ; 
	exit ;
}
// Считываем ответ - сбрасываем буфер обмена
$a = ansread( $s ) ;
echo $a, "<br/>" ;   // 220 ISP UkrNet SMTP.in (...
// 220 - Код успешного ответа. Если его нет - связь не установлена
if( strpos( $a, "220" ) === false ) {  
	echo 'Connection error' ;
	exit ;
}
	
// Здороваемся...
fputs( $s, "EHLO testunych\r\n" ) ;
$a = ansread( $s ) ; 
echo $a, "<br/>" ;    // 250-frv156.fwdcdn.com Hello testunych [185.132.3.234]....
// 250 - Код успешного ответа на этом этапе. 
if( strpos( $a, "250" ) === false ) {
	echo 'EHLO Error' ; 
	exit ;
}

// Запрашиваем авторизацию
fputs( $s, "AUTH LOGIN\r\n" ) ;
$a = ansread( $s ) ;  
echo $a, "<br/>" ;   // 334 VXNlcm5hbWU6 (Username:) 
if( strpos( $a, "334" ) === false ) {
	echo 'Username Error' ;
	exit ;
}

// Авторизируемся	
fputs( $s, $smtp_user . "\r\n" ) ;
$a = ansread( $s ) ;  
echo $a, "<br/>" ;    // 334 UGFzc3dvcmQ6 (Password:)
if( strpos( $a, "334" ) === false ) {
	echo 'Password Error' ;
	exit ;
}
fputs( $s, $smtp_pass . "\r\n" ) ;
$a = ansread( $s ) ;  
echo $a, "<br/>" ;     // 235 Authentication succeeded
if( strpos( $a, "235" ) === false ) {
	echo 'Authentication Error' ;
	exit ;
}

$to      = "denniksam@gmail.com" ;
$txtpart = "С Новым Годом!" ;
$sbj     = "Поздравления!" ;
$cmnt    = "Отправлено средствами РНР" ;

// Формируем письмо
$ml_date = date( "D, j M Y H:i:s O" ) ;  // Дата для заголовка по RFC2822
$ml_subj = $sbj ;  // Тема письма
$ml_cmts = $cmnt;  // Комментарии для заголовков
$ml_to   = $to;    // Адрессат
    
$ml_body  = "Date: $ml_date\r\n";
$ml_body .= "From: Тестуныч <$smtp_box>\r\n";
$ml_body .= "To: <$ml_to>";
$ml_body .= "Subject: $ml_subj\r\n";
$ml_body .= "Comments: $ml_cmts\r\n";
$ml_body .= "MIME-Version: 1.0\r\n";
/* // а) Text only
$ml_body .= "Content-Type: text/plain; charset=UTF-8; format=flowed\r\n";
$ml_body .= "\r\n";
$ml_body .= "$txtpart\r\n";
$ml_body .= "\r\n";	
$ml_body .= ".\r\n";
*/

/* // б) HTML - text decoration
$ml_body .= "Content-Type: text/html; charset=UTF-8; format=flowed\r\n";
$ml_body .= "\r\n";
$ml_body .= "С <b>Новым</b> <b style='color: salmon'>Годом</b>!\r\n";
$ml_body .= "\r\n";	
$ml_body .= ".\r\n";
*/
// в) Attachment(s)
$fname   = "ny.png" ;

$ml_body .= "Content-Type: multipart/mixed; boundary=\"myboundary\"\r\n";
$ml_body .= "\r\n";
$ml_body .= "This is a MIME formatted message.  If you see this text it means that your\r\n";
$ml_body .= "email software does not support MIME formatted messages.\r\n";
$ml_body .= "\r\n";
$ml_body .= "--myboundary\r\n";
// text part
$ml_body .= "Content-Type: text/plain; charset=UTF-8; format=flowed\r\n";
$ml_body .= "Content-Disposition: inline\r\n";
$ml_body .= "\r\n";
$ml_body .= "$txtpart\r\n";
$ml_body .= "\r\n";
//file part
$ml_body .= "--myboundary\r\n";
$ml_body .= "Content-Type: image/png; name=\"$fname\"\r\n";
$ml_body .= "Content-Transfer-Encoding: base64\r\n";
$ml_body .= "Content-Disposition: attachment; filename=\"$fname\";\r\n";
$ml_body .= "\r\n";
$ml_body .= base64_encode( file_get_contents( $fname ) ) ;
$ml_body .= "\r\n";
//final part
$ml_body .= "--myboundary--\r\n";
$ml_body .= "\r\n";
$ml_body .= ".\r\n";
    

fputs( $s, "MAIL FROM: $smtp_box\r\n" ) ;
$a = ansread( $s ) ;
echo $a, "<br/>" ;    //250 2.1.0 ok 
if( strpos( $a, "250" ) === false ) {
	echo 'MAIL FROM Error' ;
	exit ;
}
	
fputs( $s, "RCPT TO: $ml_to\r\n" ) ;
$a = ansread( $s ) ;
echo $a, "<br/>" ;    // 250 2.1.5 recipient ok 
if( strpos( $a, "250" ) === false ) {
	echo 'RCPT TO: Error' ;
	exit ;
}
	
fputs( $s, "DATA\r\n" ) ;
$a = ansread( $s ) ;  
echo $a, "<br/>" ;    // 354 Enter mail, end with "." on a line by itself 
if( strpos($a, "354" ) === false ) {
	echo 'DATA Error' ;
	exit ;
}
	
fputs( $s, $ml_body ) ;
$a = ansread( $s ) ;
echo $a, "<br/>" ;    // 250 OK id=1iKGpB-000IaP-Aq
if( strpos( $a, "250" ) === false ) {
	echo 'BODY Error' ;
	exit ;
}
	
// Отключаемся от SMTP
fputs( $s, "QUIT\r\n" ) ;
$a = ansread( $s ) ; 
echo $a, "<br/>" ;   // 250 OK 

echo "Done" ;	
