<?php
class LogoutMsg extends SpecialPage 
{	
	function __construct() 
	{
		parent::__construct( 'LogoutMsg' );
		wfLoadExtensionMessages('LogoutMsg');
	}
 
	function execute( $par ) 
	{
		global $wgRequest;
 
		$this->setHeaders();
		
		# Get request data from, e.g.
		$param = $wgRequest->getText('param');		
		
		global $wgOut;
		
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->addHTML( wfMsgExt( 'logouttext', array( 'parse' ) ) );
		$wgOut->returnToMain();
	}
}