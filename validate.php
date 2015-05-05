<?php
//192.168.0.33
$user = ucfirst(htmlspecialchars($_POST["username"]));
$pass = htmlspecialchars($_POST["password"]);
$noaccount = $_POST["noAccount"];
$connexuser = htmlspecialchars($_POST["connexuser"]);
//echo $noaccount."</br>";
//echo $connexuser."</br>";

//echo "test</br></br>";
if ($noaccount == 'on'){
    //echo "something";
    new_account($connexuser);
}
else{
   // echo "something";
    existing_account($user,$pass);
}

function new_account($gccuser){
  $gcplink = mysql_connect('dbserver', 'dbuser', 'dbpassword', 'dbname');
  $loggedInUser = $gccuser;//elgg_get_logged_in_user_entity()->username;
  //echo $loggedInUser."</br>";
  $query = "SELECT * FROM user WHERE user_name = '".$loggedInUser."'";
  mysql_select_db('dbname');
  $retval = mysql_query( $query, $gcplink );
  if(! $retval )
  {
    die('Could not get data: ' . mysql_error());
    //register_error('Could not get data: ' . mysql_error());
    //forward(REFERER);
  }
  while($row = mysql_fetch_assoc($retval))
  {
   // echo $row['user_password']."</br></br>";
    $gcpuser = $row['user_name'];
    
  }
  $i=1;
  //$loggedInUser = $loggedInUser.$i;
  //if ($gcpuser != NULL){
  //  register_error("user not null ".$loggedInUser);
  //}
  while ($gcpuser != NULL || $gcpuser != ''){
    
    $loggedInUser = $gccuser;//elgg_get_logged_in_user_entity()->username;
    $loggedInUser = $loggedInUser.$i;
   // echo $loggedInUser."!!</br>";
    $query = "SELECT * FROM user WHERE user_name = '".$loggedInUser."'";
    mysql_select_db('dbname');
    $retval = mysql_query( $query, $gcplink );
    if(! $retval )
    {
      die('Could not get data: ' . mysql_error());
      //register_error('Could not get data: ' . mysql_error());
      //forward(REFERER);
    }
    if (!mysql_fetch_assoc($retval)){
      $gcpuser = NULL;
    }
    //while($mysql_fetch_assoc($retval)row = mysql_fetch_assoc($retval))
    //{
      // echo $row['user_password']."</br></br>";
    //  $gcpuser = $row['user_name'];
    
    //}
    $i++;
  }
//////////////////////
  mysql_close($gcplink);
  //echo "gcpuser: ".$loggedInUser;
  header("Location: http:/ server /elgg/saml_link/add?username=".$loggedInUser);
}

function existing_account($user, $pass){
$link = mysql_connect('dbserver', 'dbuser', 'dbpassword', 'dbname');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully</br></br>';
//echo "user: ".$user.", password: ".$pass."</br></br>";
$query = "SELECT * FROM user WHERE user_name = '".$user."'";
mysql_select_db('dbname');
$retval = mysql_query( $query, $link );
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}
while($row = mysql_fetch_assoc($retval))
{
 //   echo $row['user_password']."</br></br>";
    $dbpass = $row['user_password'];
    $gcpuser = $row['user_name'];
    $gcpemail = $row['user_email'];
} 
if ($dbpass == null){
	header("Location: ".$_SERVER['HTTP_REFERER']."&invalid=true");
}
$parts = explode(':', $dbpass);
//print_r($parts);
//echo "</br></br>";
switch($parts[1]) {
    case 'A':
        $given_hash = md5($pass);
        $stored_hash = $parts[2];
        break;
    case 'B':
        $given_hash = md5($parts[2]."-".md5($pass));
        $stored_hash = $parts[3];
        break;
    default:
        throw new Exception('Unknown hash type');
        break;
}
mysql_close($link);
//echo $given_hash."</br></br>";
if( $given_hash === $stored_hash) {
    header("Location: http:// server /elgg/saml_link/add?username=".$gcpuser."&email=".$gcpemail);
//    echo "login was succesful.</br></br>";
//    echo 'user = '.$gcpuser.' '.$gcpemail;
     
} else {
	//header("Location: http://www.google.com");

    header("Location: ".$_SERVER['HTTP_REFERER']."&invalid=true");
}


}
?>