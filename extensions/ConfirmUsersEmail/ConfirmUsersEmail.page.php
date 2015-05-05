<?php
 
/**
* Class definition for the ConfirmUsersEmail special page
*/
 
class ConfirmUsersEmail extends SpecialPage {
	var $target = '';
 
	/**
	* Constructor
	*/
	function ConfirmUsersEmail() {
		SpecialPage::SpecialPage( 'ConfirmUsersEmail', 'confirmusersemail' );
	}
 
	/**
	* Main execution function
	*/
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;
 
		if( !$wgUser->isAllowed( 'confirmusersemail' ) ) {
			$wgOut->permissionRequired( 'confirmusersemail' );
			return;
		}
 
		$this->setHeaders();
 
		$this->target = $par
						? $par
						: $wgRequest->getText( 'username', '' );
 
		$wgOut->addWikiText( wfMsg( 'confirmusersemail-header' ) );
		$wgOut->addHtml( $this->makeGrantForm() );
 
		if( $this->target != '' ) {
			$wgOut->addHtml( wfElement( 'p', NULL, NULL ) );
			$user = User::newFromName( $this->target );
			if( is_object( $user ) && !is_null( $user ) ) {
				$user->load();
				# Valid username, check existence
				if( $user->getID() ) {
					if($wgRequest->getCheck('setemail') && $wgUser->isAllowed('setemail') && $wgUser->isValidEmailAddr($wgRequest->getText('email', ''))) {
						$user->setEmail($wgRequest->getText('email', ''));
						$user->confirmEmail();
						$user->sendMail( wfMsg( 'confirmusersemail-sendsubject' ), wfMsg( 'confirmusersemail-sendbody', $wgUser->getName() ) );
						$wgOut->addWikiText( wfMsg( 'confirmusersemail-success', $user->getName() ) );
					}
					# Exists; check to see if they have an email address
					if( $user->getEmail() ) {
						# They do; check to see if they are already emailconfirmed
						if( !$user->isAllowed( 'emailconfirmed' ) ) {
							#They aren't; confirm email address
							$user->confirmEmail();
							$user->sendMail( wfMsg( 'confirmusersemail-sendsubject' ), wfMsg( 'confirmusersemail-sendbody', $wgUser->getName() ) );
							$wgOut->addWikiText( wfMsg( 'confirmusersemail-success', $user->getName() ) );
						} else {
							#already confirmed, can we set a new one?
							if($wgUser->isAllowed('setemail')) {
								$wgOut->addWikiText( wfMsg( 'confirmusersemail-setconfirmed', $user->getEmail() ) );
								$wgOut->addHtml( $this->makeSetForm() );
							} else {
								$wgOut->addWikiText( wfMsg( 'confirmusersemail-alreadyconfirmed', $user->getName() ) );
							}
						}
					} else {
						# No email specified, does the user have the ability to set a new one?
						if($wgUser->isAllowed('setemail')) {
							$wgOut->addWikiText( wfMsg( 'confirmusersemail-setemail' ) );
							$wgOut->addHtml( $this->makeSetForm() );
						} else {
							$wgOut->addWikiText( wfMsg( 'confirmusersemail-noemail', $user->getName() ) );
						}
					}
				} else {
					# Doesn't exist
					$wgOut->addWikiText( wfMsg( 'nosuchusershort', htmlspecialchars( $this->target ) ) );
				}
			} else {
				# Invalid username
				$wgOut->addWikiText( wfMsg( 'noname' ) );
			}
		}
	}
 
	/**
	* Produce a form to allow for entering a user and confirming their email address
	*/
	function makeGrantForm() {
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $thisTitle->getLocalUrl() ) );
		$form .= wfElement( 'label', array( 'for' => 'username' ), wfMsg( 'confirmusersemail-username' ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'text', 'name' => 'username', 'id' => 'username', 'value' => $this->target ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'submit', 'name' => 'confirm', 'value' => wfMsg( 'confirmusersemail-confirm' ) ) );
		$form .= wfCloseElement( 'form' );
		return $form;
	}
 
	/**
	* Produce a form to allow setting a user's email address
	*/
 
	function makeSetForm() {
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $thisTitle->getLocalUrl() ) );
		$form .= wfElement( 'label', array( 'for' => 'email' ), wfMsg( 'confirmusersemail-email' ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'text', 'name' => 'email', 'id' => 'email', 'value' => $this->email ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'hidden', 'name' => 'username', 'id' => 'username', 'value' => $this->target ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'submit', 'name' => 'setemail', 'value' => wfMsg( 'confirmusersemail-set' ) ) );
		$form .= wfCloseElement( 'form' );
		return $form;
	}
}