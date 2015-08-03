<?php
require 'parser.php';
require 'db.php';

function setproxy( &$ch ) {
 //// Configure Proxy Settings, if required
	
	//curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_NTLM); 
	//curl_setopt($ch, CURLOPT_PROXY, '');    
	//curl_setopt($ch, CURLOPT_PROXYPORT, 8080); 
}


//// Set cookie and get Captcha
function open($id)
{
	$cookie = dirname(__FILE__) . "/cookie/" . $id .".txt";
    
	$ch = curl_init(); 
	setproxy( $ch );
    curl_setopt($ch, CURLOPT_URL,'https://academics.vit.ac.in/parent/captcha.asp');  
    curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
	
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_VERBOSE, 1); 
    curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt ($ch, CURLOPT_REFERER, 'https://academics.vit.ac.in/parent/parent_login.asp');
    $result = curl_exec($ch);  
	
	$fp = fopen("jpg/".$id.".jpg",'w');
	fwrite($fp, $result); 
	fclose($fp);
	header('content-type: image/jpeg');
    die( $result );
}


//// Login and call Parser to fetch Timetable
function getData()
{
    $capth=htmlspecialchars($_GET['cap']);
	
	$username = $_GET['reg']; 
	$password = $_GET['dd'];
	$mobile = $_GET['m'];
	$url="https://academics.vit.ac.in/parent/parent_login_submit.asp"; 
	$cookie = dirname(__FILE__) . "/cookie/" . $_GET['hash'] .".txt";
    $veri=$capth;


	$postdata = "wdregno=".$username."&wdpswd=".$password."&wdmobno=".$mobile."&vrfcd=".$veri;
	
	$ch = curl_init(); 
	setproxy( $ch );
	curl_setopt ($ch, CURLOPT_URL, $url); 
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
	curl_setopt ($ch, CURLOPT_TIMEOUT, 260); 
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie); 
	curl_setopt ($ch, CURLOPT_REFERER, 'https://academics.vit.ac.in/parent/parent_login.asp'); 

	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
	curl_setopt ($ch, CURLOPT_POST, 1); 
	$result = curl_exec ($ch); 
	
	
	$ch = curl_init(); 
	setproxy( $ch );
	
    curl_setopt($ch, CURLOPT_URL,'https://academics.vit.ac.in/parent/timetable.asp?sem=FS');  
    curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_VERBOSE, 1); 
    curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt ($ch, CURLOPT_REFERER, 'https://academics.vit.ac.in/parent/home.asp');
    $result = curl_exec($ch);  

//// Uncomment To View Timetable [Debugging]	
//	echo $result; 
	
	$id = $_GET['reg'];
	$dd = $_GET['dd'];
	$stamp = md5(time());

//// The parser is called here	

	if( parser($result,$id) ) {
	 
//// Login was successful! Add this user to registered user table or something..

 /*	
	  mysql_query("INSERT INTO users( name, regno, pass, birthday, auth ) VALUES( '$name', '$id', '$pass', '$dd', '$stamp' )");
	  
	 echo "Registration Successful :D";
*/
	}
	else
	 die("Whoops! Something went wrong. Please recheck your ID, birthday and captcha.");

}

/*-----------------------------------------------------------------------*/

if( isset( $_GET['id'] ) ) { open( $_GET['id'] ); }

if( isset( $_GET['reg'] ) && isset( $_GET['dd'] ) && isset( $_GET['hash'] ) && isset( $_GET['cap'] ) && isset( $_GET['m'] ) ) 
    {  getData();	}
	
/*-----------------------------------------------------------------------*/
 

?>
