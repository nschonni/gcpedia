
			<script src="<?php echo $wgScriptPath ?>/load.php?debug=false&amp;lang=en&amp;modules=startup&amp;only=scripts&amp;skin=monobook&amp;*" type="text/javascript"></script>
<script type="text/javascript">if ( window.mediaWiki ) {
	mediaWiki.config.set({"wgCanonicalNamespace": "Special", "wgCanonicalSpecialPageName": "Userlogin", "wgNamespaceNumber": -1, "wgPageName": "Special:UserLogin", "wgTitle": "UserLogin", "wgAction": "view", "wgArticleId": 0, "wgIsArticle": false, "wgUserName": null, "wgUserGroups": ["*"], "wgCurRevisionId": 0, "wgCategories": [], "wgBreakFrames": false, "wgRestrictionCreate": [], "wgSearchNamespaces": [0], "wgFCKEditorDir": "extensions/WYSIWYG/ckeditor/", "wgFCKEditorExtDir": "extensions/WYSIWYG", "wgFCKEditorToolbarSet": "Wiki", "wgFCKEditorHeight": "0", "wgCKeditorMagicWords": {"wikitags": ["nowiki", "includeonly", "onlyinclude", "noinclude", "tagcloud", "video", "wikiflv", "videoflash", "multilang", "poll", "gc_poll", "accesscontrol", "section", "dpl", "dynamicpagelist", "pre", "gallery", "inputbox", "ref", "references", "imagemap", "languageselector"], "magicwords": ["NOTOC", "FORCETOC", "TOC", "NOEDITSECTION", "NEWSECTIONLINK", "NONEWSECTIONLINK", "NOCONTENTCONVERT", "NOCC", "NOTITLECONVERT", "NOTC", "NOGALLERY", "INDEX", "NOINDEX", "STATICREDIRECT", "NOGALLERY", "HIDDENCAT", "START", "END"], "datevars": ["CURRENTYEAR", "CURRENTMONTH", "CURRENTMONTHNAME", "CURRENTMONTHNAMEGEN", "CURRENTMONTHABBREV", "CURRENTDAY", "CURRENTDAY2", "CURRENTDOW", "CURRENTDAYNAME", "CURRENTTIME", "CURRENTHOUR", "CURRENTWEEK", "CURRENTTIMESTAMP"], "wikivars": ["SITENAME", "SERVER", "SERVERNAME", "DIRMARK", "SCRIPTPATH", "CURRENTVERSION", "CONTENTLANG", "REVISIONID", "REVISIONDAY", "REVISIONDAY2", "REVISIONMONTH", "REVISIONYEAR", "REVISIONTIMESTAMP", "REVISIONUSER", "FULLPAGENAME", "PAGENAME", "BASEPAGENAME", "SUBPAGENAME", "SUBJECTPAGENAME", "TALKPAGENAME", "NAMESPACE", "ARTICLESPACE", "TALKSPACE"], "parserhooks": ["lc", "lcfirst", "uc", "ucfirst", "formatnum", "#dateformat", "padleft", "padright", "plural", "grammar", "#language", "int", "#tag", "#css", "#dpl", "#dplnum", "#dplchapter", "#dplmatrix", "#int", "#ns", "#nse", "#urlencode", "#lcfirst", "#ucfirst", "#lc", "#uc", "#localurl", "#localurle", "#fullurl", "#fullurle", "#formatnum", "#grammar", "#gender", "#plural", "#numberofpages", "#numberofusers", "#numberofactiveusers", "#numberofarticles", "#numberoffiles", "#numberofadmins", "#numberingroup", "#numberofedits", "#numberofviews", "#padleft", "#padright", "#anchorencode", "#special", "#defaultsort", "#filepath", "#pagesincategory", "#pagesize", "#protectionlevel", "#namespace", "#namespacee", "#talkspace", "#talkspacee", "#subjectspace", "#subjectspacee", "#pagename", "#pagenamee", "#fullpagename", "#fullpagenamee", "#basepagename", "#basepagenamee", "#subpagename", "#subpagenamee", "#talkpagename", "#talkpagenamee", "#subjectpagename", "#subjectpagenamee", "#formatdate", "#displaytitle", "#widget", "#if", "#ifeq", "#switch", "#ifexist", "#ifexpr", "#iferror", "#expr", "#time", "#timel", "#rel2abs", "#titleparts"]}, "wgCKeditorUseBuildin4Extensions": []});
}
</script>
<script type="text/javascript">if ( window.mediaWiki ) {
	mediaWiki.loader.load(["mediawiki.util", "mediawiki.legacy.wikibits", "mediawiki.legacy.ajax", "mediawiki.legacy.mwsuggest"]);
	mediaWiki.loader.go();
}
</script>

<script type="text/javascript">
		addOnloadHook(function() { 
			var i = 1;
			while ( true ) {
				var btn = document.getElementById("languageselector-commit-"+i);
				var sel = document.getElementById("languageselector-select-"+i);
				var idx = i;

				if (!btn) break;

				btn.style.display = "none";
				sel.onchange = function() { this.parentNode.submit(); };

				i++;
			}
		});
	</script>

<script src="<?php echo $wgScriptPath ?>/load.php?debug=false&amp;lang=en&amp;modules=site&amp;only=scripts&amp;skin=monobook&amp;*" type="text/javascript"></script>
<script type="text/javascript">if ( window.mediaWiki ) {
	mediaWiki.user.options.set({"ccmeonemails":0,"cols":80,"contextchars":50,"contextlines":5,"date":"default","diffonly":0,"disablemail":0,"disablesuggest":0,"editfont":"default","editondblclick":0,"editsection":1,"editsectiononrightclick":0,"enotifminoredits":0,"enotifrevealaddr":0,"enotifusertalkpages":1,"enotifwatchlistpages":0,"extendwatchlist":0,"externaldiff":0,"externaleditor":0,"fancysig":0,"forceeditsummary":0,"gender":"unknown","hideminor":0,"hidepatrolled":0,"highlightbroken":1,"imagesize":2,"justify":0,"math":1,"minordefault":0,"newpageshidepatrolled":0,"nocache":0,"noconvertlink":0,"norollbackdiff":0,"numberheadings":0,"previewonfirst":0,"previewontop":1,"quickbar":1,"rcdays":7,"rclimit":50,"rememberpassword":0,"rows":25,"searchlimit":20,"showhiddencats":0,"showjumplinks":1,"shownumberswatching":1,"showtoc":1,"showtoolbar":1,"skin":"monobook","stubthreshold":0,"thumbsize":2,"underline":2,"uselivepreview":0,"usenewrc":0,"watchcreations":0,"watchdefault":0,"watchdeletion":0,
	"watchlistdays":3,"watchlisthideanons":0,"watchlisthidebots":0,"watchlisthideliu":0,"watchlisthideminor":0,"watchlisthideown":0,"watchlisthidepatrolled":0,"watchmoves":0,"wllimit":250,"riched_use_toggle":1,"riched_start_disabled":1,"riched_use_popup":1,"riched_toggle_remember_state":1,"variant":"en","language":"en","searchNs0":true,"searchNs1":false,"searchNs2":false,"searchNs3":false,"searchNs4":false,"searchNs5":false,"searchNs6":false,"searchNs7":false,"searchNs8":false,"searchNs9":false,"searchNs10":false,"searchNs11":false,"searchNs12":false,"searchNs13":false,"searchNs14":false,"searchNs15":false,"searchNs100":false,"searchNs101":false,"searchNs102":false,"searchNs103":false,"searchNs274":false,"searchNs275":false});;mediaWiki.loader.state({"user.options":"ready"});
}
</script>
	




















class disclaimerHead extends QuickTemplate

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php 
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
	<head>
	

		<title>GCPEDIA Disclaimer</title>

	
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>
		<style type="text/css" media="screen, projection">/*<![CDATA[*/
			@import "<?php $this->text('stylepath') ?>/common/shared.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";
			@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/main.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";
		/*]]>*/</style>
		<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('printcss') ?>?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
		<?php if( in_array( 'IE50', $skin->cssfiles ) ) { ?><!--[if lt IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE50Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<?php } if( in_array( 'IE55', $skin->cssfiles ) ) { ?><!--[if IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE55Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<?php } if( in_array( 'IE60', $skin->cssfiles ) ) { ?><!--[if IE 6]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE60Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<?php } if( in_array( 'IE70', $skin->cssfiles ) ) { ?><!--[if IE 7]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE70Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<?php } ?><!--[if lt IE 7]><?php if( in_array( 'IE', $skin->cssfiles ) ) { ?><script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
		<?php } ?><meta http-equiv="imagetoolbar" content="no" /><![endif]-->
		<link rel="stylesheet" href="<?php echo $wgScriptPath; ?>/skins/common/shared.css?270" media="screen" />
		<link rel="stylesheet" href="<?php echo $wgScriptPath; ?>/skins/monobook/main.css?270" media="screen" />

                
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
		<!-- Head Scripts -->
<?php $this->html('headscripts') ?>
<?php	if($this->data['jsvarurl']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl') ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss']) { ?>
		<style type="text/css"><?php $this->html('pagecss') ?></style>
<?php	}
		if($this->data['usercss']) { ?>
		<style type="text/css"><?php $this->html('usercss') ?></style>
<?php	}
		if($this->data['userjs']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
<!-- Head Scripts -->
<script type="text/javascript">
		addOnloadHook(function() {
			var i = 1;
			while ( true ) {
				var btn = document.getElementById("languageselector-commit-"+i);
				var sel = document.getElementById("languageselector-select-"+i);
				var idx = i;
				
				if (!btn) break;
				
				btn.style.display = "none";
				sel.onchange = function() { this.parentNode.submit(); };
				
				i++;
			}
		});
		
		function getChecked() {
			if( document.getElementById('accept').checked == true && document.getElementById('emailcheck').checked == true ) { 
				document.getElementById('proceed').disabled=0
			} else { 
				document.getElementById('proceed').disabled=1
			}
		}
	</script>
	<script src="<?php echo $wgScriptPath; ?>/skins/common/ajax.js?270"></script>
	<script src="<?php echo $wgScriptPath; ?>/skins/common/ajaxwatch.js?270"></script>
	<script src="<?php echo $wgScriptPath; ?>/skins/common/mwsuggest.js?270"></script>
	<script src="<?php echo $wgScriptPath; ?>/skins/common/rightclickedit.js?270"></script>
	<script type="text/javascript" src="<?php echo $wgScriptPath; ?>/index.php?title=-&amp;action=raw&amp;smaxage=0&amp;gen=js&amp;useskin=monobook"><!-- site js --></script>
	</head>
			
	<?php