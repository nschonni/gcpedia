<?php
/** RSS-Feed MediaWiki extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Jason Nuyens
 * @copyright © Fenix Solutions
 * @link 
 *
 */
 
require_once("DatabaseFunctions.php");
 
if( !defined( 'MEDIAWIKI' ) ) {
        die();
}
 
$wgExtensionCredits['other'][] = array(
        'name' => 'Recent Item Blocks',
        'author' => array('Jason Nuyens'),
        'version' => '04/2008',
        'url' => '',
        'description' => 'Displays recent item blocks on the home page.'
); 

#install extension hook
$wgExtensionFunctions[] = "wfRecentItemsExtension"; 
 
#extension hook callback function
function wfRecentItemsExtension() { 
   global $wgParser;
 
   #install parser hook for <recentitem> tags
   $wgParser->setHook( "recentitems", "renderRecentItems" );
}

function renderRecentItems() {
	
	  global $wgVersion;
 
        # Do not cache this wiki page.
        # for details see http://public.kitware.com/Wiki/User:Barre/MediaWiki/Extensions
        global $wgTitle, $wgDBprefix, $wgUser;
        $ts = time();
        $now = gmdate("YmdHis", $ts + 120);
        $ns = $wgTitle->getNamespace();
        $ti = wfStrencode($wgTitle->getDBkey()); 
     
     
		$query2 = 
					"
					SELECT p.page_counter, p.page_title, cast(rc.rc_timestamp as DATETIME) as thedate, cast(rc.rc_timestamp as DATETIME) > (NOW() - INTERVAL 1 WEEK) as oneweekago
					FROM page p
					INNER JOIN recentchanges rc
					   ON p.page_title = rc.rc_title
					WHERE 
						rc.rc_new = 1 AND
						rc.rc_namespace = 0
					GROUP BY p.page_title
					HAVING thedate > oneweekago
					ORDER BY page_counter DESC
					LIMIT 3"; 
					$result2= wfQuery($query2, DB_READ);
					if ($wgUser->mOptions['language'] == 'fr') {
						$output .=" <div class='rightBox' id='mostPopularFR'><div class='header'>&nbsp;</div><ul>";
					} else {
						$output .=" <div class='rightBox' id='mostPopular'><div class='header'>&nbsp;</div><ul>";
					}
			 while($line2 = wfFetchObject($result2))
				 {
					$output .= '<li><a href="/index.php?title=' . $line2->page_title . '">' . str_replace("_"," ",$line2->page_title) . '</a></li>';
                 } 
		$output .="   </ul></div>";
		return $output;	
		
}
?>