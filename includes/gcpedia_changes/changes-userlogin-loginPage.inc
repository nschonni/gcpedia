<?php

// must be included in Userlogin.php after the 'wpName1' text input box
// this files changes the standard mediaWiki way of displaying name (with a capital first letter) to all lower case letters

// note: this file must be included in userlogin inorder to work, it requires the text function which is which is part of the UserloginTemplate class 

?>

<script type="text/javascript">
	username = '<?php $this->text('name') ?>';
	document.getElementById("wpName1").value = username.toLowerCase();
</script>