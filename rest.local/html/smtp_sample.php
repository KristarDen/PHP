<?php
$smtp_prot="ssl";
$smtp_host="smtp.ukr.net";
$smtp_port="465";
$smtp_pass="kHIey6ANKTP0m2w1";
$smtp_user="php_gallery";

$smtp_context = array('ssl' => array('verify_peer'=> false, 'verify_peer_name' => false));
$smtp_box="demirov_denis@ukr.net";  // Razrab0tka

function ansread($sc){//Получение ответа из сокета 
  $rt="";
  while($st = fgets($sc,254)){
    $rt .= $st."<br/>";
    if(substr($st,3,1) == " ")  break; 
  }
  return $rt;
}

$to      = "denis216051@gmail.com";
$txtpart = "Text part of letter";
$fname   = "updown.jpg";
$sbj     = "Изучаем SMTP" ;
$cmnt    = "Отправлено средствами РНР";

$stc = stream_context_create($smtp_context);
	$s = stream_socket_client($smtp_prot."://".$smtp_host.":".$smtp_port,$errno,$errstr,10,STREAM_CLIENT_CONNECT,$stc);
	if(!$s){//Проверяем успещность открытия сокета
		echo $errstr ; exit ;
	}
	// Считываем ответ - сбрасываем буфер обмена
	$a = ansread($s);  // 220 ISP UkrNet SMTP.in (frv155.fwdcdn.com) ESMTP Tue, 15 Oct 2019 09:44:12 +0300
echo $a,"<br/>"; // exit ;
  
	if(strpos($a,"220")===false){  // 220 - Код успешного ответа. Если его нет - связь не установлена
		 echo '-1';exit;
	}
	
	//Здороваемся...
	fputs($s,"EHLO testunych\r\n");
	$a = ansread($s);//250-frv158.fwdcdn.com Hello testunych ...
echo $a,"<br/>";    
		if(strpos($a,"250")===false){
		echo '-2'; exit;
	}
	
	//Запрашиваем авторизацию
	fputs($s,"AUTH LOGIN\r\n");
	$a = ansread($s);  // 334 VXNlcm5hbWU6 (Username:) 
echo $a,"<br/>";   
		if(strpos($a,"334")===false){
		echo '-3';exit;
	}

	//Авторизируемся	
	fputs($s,$smtp_user."\r\n");
	$a = ansread($s);  // 334 UGFzc3dvcmQ6 (Password:)
echo $a,"<br/>";    
		if(strpos($a,"334")===false){
		echo '-4';exit;
	}
	fputs($s,$smtp_pass."\r\n");
	$a = ansread($s);  // 235 Authentication succeeded
echo $a,"<br/>";     
		if(strpos($a,"235")===false){
		echo '-5';exit;
	}
	
	//Формируем письмо
	$ml_date = date("D, j M Y H:i:s O");  // Дата для заголовка по RFC2822
	$ml_subj = $sbj ;  // Тема письма
	$ml_cmts = $cmnt;  // Комментарии для заголовков
	$ml_to   = $to;    //Адрессат
    
    $ml_body  = "Date: $ml_date\r\n";
    $ml_body .= "From: Proviryalovich <$smtp_box>\r\n";
    $ml_body .= "To: <$ml_to>";
    $ml_body .= "Subject: $ml_subj\r\n";
    $ml_body .= "Comments: $ml_cmts\r\n";
    $ml_body .= "MIME-Version: 1.0\r\n";
    $ml_body .= "Content-Type: multipart/mixed; boundary=\"slcubound\"\r\n";
    $ml_body .= "\r\n";
    $ml_body .= "This is a MIME formatted message.  If you see this text it means that your\r\n";
    $ml_body .= "email software does not support MIME formatted messages.\r\n";
    $ml_body .= "\r\n";
	$ml_body .= "--slcubound\r\n";
    // text part
    $ml_body .= "Content-Type: text/plain; charset=UTF-8; format=flowed\r\n";
    $ml_body .= "Content-Disposition: inline\r\n";
    $ml_body .= "\r\n";
    $ml_body .= "$txtpart\r\n";
    $ml_body .= "\r\n";
    //file part
    $ml_body .= "--slcubound\r\n";
    $ml_body .= "Content-Type: image/jpeg; name=\"$fname\"\r\n";
    $ml_body .= "Content-Transfer-Encoding: base64\r\n";
    $ml_body .= "Content-Disposition: attachment; filename=\"$fname\";\r\n";
    $ml_body .= "\r\n";
    $ml_body .= base64_encode(file_get_contents($fname));
    $ml_body .= "\r\n";
    //final part
    $ml_body .= "--slcubound--\r\n";
    $ml_body .= "\r\n";
    $ml_body .= ".\r\n";
    
    
	fputs($s,"MAIL FROM: $smtp_box\r\n");
	$a = ansread($s);//250 2.1.0 ok 
echo $a,"<br/>";    
		if(strpos($a,"250")===false){
		echo '-6';exit;
	}
	
	fputs($s,"RCPT TO: $ml_to\r\n");
	$a2 = ansread($s);//250 2.1.5 recipient ok 
echo $a2,"<br/>";    
		if(strpos($a2,"250")===false){
		echo '-7';exit;
	}
	
	fputs($s,"DATA\r\n");
	$a3 = ansread($s);//354 Enter mail, end with "." on a line by itself 
echo $a3,"<br/>";    
		if(strpos($a3,"354")===false){
		echo '-8';exit;
	}
	
	fputs($s,$ml_body);
	$a4 = ansread($s);//250 OK id=1iKGpB-000IaP-Aq
echo $a4,"<br/>";    
		if(strpos($a4,"250")===false){
		echo '-9';exit;
	}
	
	//Отключаемся от SMTP
	fputs($s,"QUIT\r\n");
	ansread($s); //250 OK 
echo $a,"<br/>";    
echo "Done";	
