<?php
/**
 * GCSimple extension of SkinTemplate
 */
class SkinGCSimple extends SkinTemplate {

	var $skinname = 'gcsimple', $stylename = 'gcsimple',
		$template = 'GCSimpleTemplate', $useHeadElement = true;

	/**
	 * Add a bunch of elements to the head
	 */
	function initPage( OutputPage $out ) {
		global $wgScriptPath;
		parent::initPage( $out );
		$out->addHeadItem( 'viewport', "<meta name='viewport' content='width=device-width' />\n" );
		$out->addHeadItem( 'csswidth', "<style type='text/css'>@-ms-viewport{width: device-width;} @-o-viewport{width: device-width;} @viewport{width: device-width;}</style>\n" );
		$out->addHeadItem( 'csslink', '<link rel="stylesheet" href="' . $wgScriptPath . '/skins/gcsimple/gcstyle.css" />' . "\n" );
		$out->addHeadItem( 'javascript', "<script type=\"text/javascript\" src=\"" . $wgScriptPath . "/skins/gcsimple/jquery.js\"></script>\n" );
		$out->addHeadItem( 'ajaxscript', "<script type=\"text/javascript\" src=\"" . $wgScriptPath . "/skins/common/ajax.js\"></script>\n" );
	}

	function setupSkinUserCss( OutputPage $out ){
		parent::setupSkinUserCss( $out );
	}

}

/**
 * GCSimple extension of BaseTemplate
 */
class GCSimpleTemplate extends BaseTemplate {

	/**
	 * Creates the page
	 */
	public function execute() {
		if (!isset($this->data['sitename'])){
			global $wgSitename;
			$this->set( 'sitename', $wgSitename );
		}
		global $wgScriptPath;
		global $wgUser;
		wfSuppressWarnings();
		$this->html( 'headelement' );
?>
	<body>
		<div id="topsection">
			<table>
				<?php $sidebar = $this->getSidebar(); ?>
				<tr>
					<td class="listtitle">
						<?php echo $sidebar['navigation']['header']; ?>
					</td>
					<td>
						<?php foreach ( $sidebar['navigation']['content'] as $key => $item ) { ?>
							<?php echo $this->makeListItem( $key, $item, array( 'tag' => 'span' ) ); ?>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td class="listtitle" id="toggle-container">
						<span id="show-more-link" title="<?php echo $this->msg( 'gcsimple-more' ); ?>">
							<?php echo $this->msg( 'gcsimple-personal' ); ?>
							<img src="<?php echo $wgScriptPath . "/skins/gcsimple/arrow-more.png" ?>" id="show-more-img"></img>
						</span>
						<span id="show-less-link" title="<?php echo $this->msg( 'gcsimple-less' ); ?>">
							<?php echo $this->msg( 'gcsimple-personal' ); ?>
							<img src="<?php echo $wgScriptPath . "/skins/gcsimple/arrow-less.png" ?>" id="show-less-img"></img>
						</span>
					</td>
					<td>
						<span>
							<a href="<?php echo updateURLQuery( $_SERVER['PHP_SELF'], 'useskin', $wgUser->getOption('skin') ); ?>"><?php $this->msg( 'gcsimple-desktop' ) ?></a>
						</span>
						<?php foreach ( $this->getPersonalTools() as $key => $item ) { ?>
							<?php echo $this->makeListItem( $key, $item, array( 'tag' => 'span' ) ); ?>
						<?php } ?>
					</td>
				</tr>
				<tr class="toggle-my-visibility">
					<td class="listtitle">
						<?php $this->msg( 'gcsimple-actions' ); ?>
					</td>
					<td>
						<?php foreach ( $this->data['content_actions'] as $key => $tab ) { ?>
							<?php echo $this->makeListItem( $key, $tab, array( 'tag' => 'span' ) ); ?>
						<?php } ?>
					</td>
				</tr>
				<tr class="toggle-my-visibility">
					<td class="listtitle">
						GC 2.0
					</td>
					<td>
						<span>
							<a href="http://www.gcconnex.gc.ca/">GCconnex</a>
						</span>
						<span>
							<a href="http://www.gcforums.gc.ca/">GCforums</a>
						</span>
					</td>
				</tr>
				<tr class="toggle-my-visibility">
					<td class="listtitle">
						<?php $this->msg( 'gcsimple-support' ); ?>
					</td>
					<td>
						<?php foreach ( $sidebar['support']['content'] as $key => $tab ) { ?>
							<?php echo $this->makeListItem( $key, $tab, array( 'tag' => 'span' ) ); ?>
						<?php } ?>
					</td>
				</tr>
				<tr class="toggle-my-visibility">
					<td class="listtitle">
						<?php $this->msg( 'toolbox' ); ?>
					</td>
					<td>
						<?php foreach ( $this->getToolbox() as $key => $tbitem ) { ?>
							<?php echo $this->makeListItem( $key, $tbitem, array( 'tag' => 'span' ) ); ?>
						<?php } ?>
					</td>
				</tr>
				<tr id="searchform">
					<td class="listtitle">
						<?php echo $this->translator->translate( 'search' ) ?>
					</td>
					<td>
						<form action="<?php $this->text( 'wgScript' ); ?>">
							<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
							<?php echo $this->makeSearchInput( array( 'id' => 'searchinput' ) ); ?>
							<?php echo $this->makeSearchButton( 'go', array( 'value' => $this->translator->translate( 'go' ), 'id' => 'searchbutton' ) ); ?>
						</form>
					</td>
				</tr>
			</table>
		</div>
		<div id="mw-js-message" style="display:none;">
			<?php if ( $this->data['newtalk'] ) { $this->html( 'newtalk' ); } ?>
			<?php if ( $this->data['sitenotice'] ) { echo "<br />"; $this->html( 'sitenotice' ); } ?>
		</div>
		<h1 id="firstHeading"><?php $this->html('title'); ?></h1>
		<?php $this->html('bodytext'); ?>
	</body>
</html>
<?php
		wfRestoreWarnings();
	}

}
