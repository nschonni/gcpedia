<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<?php $gccuser = htmlspecialchars($_GET["username"]); ?>
<?php $invalid = htmlspecialchars($_GET["invalid"]); ?>
<?php $passedlang = htmlspecialchars($_GET["lang"]); ?>
<?php
	if(!isset($_COOKIE['connex_lang'])) {
    		$cookielang = $passedlang;
	}else{
		$cookielang = $_COOKIE['connex_lang'];
	}
	if ($cookielang == 'en'){
		include 'en.php';
	}else {
		include 'fr.php';
	}
	 
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="special.css">
		<title><?php echo $lang['title']; ?></title>
	</head>
	<body>
		
		<div id="form">
			<form id="langform">
				<div class ="lang_toggle">
				<?php
			
					if ($cookielang == 'en') { 
			

				?>
				<span class="active">English</span>
				<a class="not_active" href="javascript:form_submit('French')">Fran&ccedil;ais</a>


				<?php
					} else { 
				?>
				<a class="not_active" href="javascript:form_submit('English')">English</a>
				<span class="active">Fran&ccedil;ais</span>

				<?php
				}

			
				?>
				</div>
			</form>
			<h2><?php echo $lang['title']; ?></h2>
			<?php echo $lang['body']; ?>
			<?php
				if ($invalid=='true'){
					echo "<span style='color:red'><b>".$lang['badlogin']."</b></span>";
				}

			?>
			<form id="loginform" action="validate.php" method="POST">
				<div>
					
			
					<div style="border-right:1px solid #000;float:left;padding-right:25px;">
						<?php echo $lang['username']; ?><br>
						<input id='myid'class='text' type="text" name="username" value="">
						<br>
						<?php echo $lang['password']; ?><br>
						<input class='text' id="passbox" type="password" name="password" value="">
						<br>
						<a href='http://www.gcpedia.gc.ca/gcwiki/index.php?title=Special:UserLogin' target="_blank"><?php echo $lang['forgotuser']; ?></a>
						<br> <a href='http://www.gcpedia.gc.ca/wiki/Special:PasswordReset' target="_blank"><?php echo $lang['forgotpass']; ?></a>
						<br>
						<?php
							echo "<input id='connexuser' type='hidden' name='connexuser' value='".$gccuser."'>";
						?>
					</div>
					<div style='padding-left:25px;float:left;'>
						<?php echo $lang['checkbox']; ?>
						<input class='check' type="checkbox" name="noAccount" onclick='OnChangeCheckbox(this)'></br></br>
					</div>
				</div>
				<div style='width:100%;float:left;'>
					<input class='button' type="submit" value="<?php echo $lang['button']; ?>" style='margin-top:20px;'>
				</div>
				<script>
					
    				function OnChangeCheckbox(checkbox) {
						
   						if (checkbox.checked) {

      						document.getElementById("myid").value = '';
      						document.getElementById("myid").style.backgroundColor = 'lightgrey';
      						document.getElementById("myid").disabled = true;
      						document.getElementById("passbox").value = '';
      						document.getElementById("passbox").style.backgroundColor = 'lightgrey';
       						document.getElementById("passbox").disabled = true;
   						}
   						else {
      						
      						document.getElementById("myid").style.backgroundColor = 'white';
      						document.getElementById("myid").disabled = false;
       						document.getElementById("passbox").style.backgroundColor = 'white';
       						document.getElementById("passbox").disabled = false;
   						}
					}
					function form_submit(language_selected) {
			//document.getElementById('formtoggle').submit();

						var c_name = "connex_lang";
						var c_value = document.cookie;
						var c_start = c_value.indexOf(" " + c_name + "=");
			
						//alert("check1");
						if (c_start == -1){
							c_start = c_value.indexOf(c_name + "=");
						}

						if (c_start == -1) 
						{
							c_value = null;
						} else {

							c_start = c_value.indexOf("=", c_start) + 1;
							var c_end = c_value.indexOf(";", c_start);
							if (c_end == -1) {
								c_end = c_value.length;
							}
							c_value = unescape(c_value.substring(c_start,c_end));
						}

			
						if (c_value == null)
						{
							
							if (language_selected == "English"){
								set_cookie(c_name, "en");

							} else {
								if (language_selected == "French")
								{
									set_cookie(c_name,"fr");
								}
							}
							parent.location.reload(true);
						} else {

							if (c_value == "en"){
								set_cookie(c_name,"fr");
							} else {
								set_cookie(c_name, "en");
							}
							parent.location.reload(true);
						}
					}
					function set_cookie(name,value) {
						var today = new Date();
						today.setTime( today.getTime() );
						expires = 1000 * 60 * 60 * 24;
						var expires_date = new Date( today.getTime() + (expires) );
						document.cookie = name + "=" +escape( value ) + ";path=/" + ";expires=" + expires_date.toGMTString();
					}


				</script>

			</form>
		</div>
			
	</body>
</html>