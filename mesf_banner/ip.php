<?
Header("content-type: application/x-javascript");

if (!ini_get('register_globals')) {
$reg_globals = array($_POST, $_GET, $_FILES, $_ENV, $_SERVER, $_COOKIE);
if (isset($_SESSION)) {
array_unshift($reg_globals, $_SESSION);
}
foreach ($reg_globals as $reg_global) {
extract($reg_global, EXTR_SKIP);
}
}
//Find the IP of the visitor    
     if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){$rip = getenv("HTTP_CLIENT_IP");
     }
     else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
     {
        $rip = getenv("HTTP_X_FORWARDED_FOR");
     }
     else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
     {
        $rip = getenv("REMOTE_ADDR");
     }
     else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],

"unknown"))
     {
        $rip = $_SERVER['REMOTE_ADDR'];
     }
     else
     {
        $rip = "unknown";
     }

$clienthostname2=gethostbyaddr($rip);
//echo $clienthostname2;
//echo "document.write(\"Your IP address is: <b>" . $clienthostname2 . "</b>\");";
echo 'var hostname="'.$clienthostname2.'";'; //Define string in JavaScript



?>
