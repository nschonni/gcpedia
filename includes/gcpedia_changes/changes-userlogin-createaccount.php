<?php 

/***

	Used on includes/template/Userlogin.php for validating user content
	You place the file at the point in the document you wish the error messages to show up
	
	@dependencies
	
		this requires validateCreateAccount.js which is contained in the includes/GCPEDIA_CHANGES/ folder

***/


global $wgLang;
?>
	
<script type="text/javascript">
	var lang = '<?php echo $wgLang->getCode(); ?>';
</script>
<!--<script type="text/javascript" src="includes/GCPEDIA_CHANGES/validateCreateAccount.js"></script>-->
<script type="text/javascript" src="skins/common/validateCreateAccount.js"></script>
<div id="errorList"></div>