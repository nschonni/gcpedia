<?php
/**
 * DeletePagePermanently.php
 * based on Version 1.0 BETA from Ludovic MOUTON (2008)
 * Wolfgang Stöttinger 2008
 * v. 2.1.3 BETA
 * GPL
 * 
 * BE CAREFUL WHEN USING THIS EXTENSION. ONCE A PAGE IS DELETED, IT CAN NOT BE RESTORED ANY MORE.
 * Changed in Version 2.1.3:
 *              - Correctly displays on Vector skin
 *              - Also deletes thumbnails on images
 *              - Using alternate methods to delete files due do deprecation of FileStore in MW 1.16.x
 * Changed in Version 2.1.2:
 *              - Update category count
 * Changed in Version 2.1.1:
 *              - Title is removed from cache.
 * Changed in Version 2.1.0:
 *              - deletePage() can now be used from outside in PHP.
 * 
 * Features of Version 2.0:
 *              - defined $wgDeletePagePermanentlyNamespaces as an array of namespaces in which pages can be deleted.
 *                      $wgDeletePagePermanentlyNamespaces = array (
 *                              NS_MAIN => true,
 *                              NS_IMAGE => true,
 *                              NS_CATEGORY => true,
 *                              NS_TEMPLATE => true,
 *                              NS_TALK => true,
 *                      );
 *              
 *              - The tab "Delete permanently" is only shown on pages that can be deleted.
 *              - An aditional page to approve the deletion
 *              - Also log entries are deleted.
 *              - Also redirects, external links, language links, searchindex entries, page_restrictions, pagelinks, categorylinks, templatelinks, archive entries and image links are deleted.
 *              - The watchlist entries are also removed.
 *              - If the page is an image page, all versions of the image are deleted from the database, the archive and the filesystem. (Thumbnlais won't be removed)
*/
 
if (!defined('MEDIAWIKI')) {
        exit(1);
}
 
$wgExtensionCredits['other'][] = array (
        'name' => 'DeletePagePermanently',
        'version' => '2.1',
        'author' => 'Ludovic MOUTON, Wolfgang STOTTINGER',
        'description' => 'Adds a new delete tab to each page. Pages are deleted permanently from the database.',
        'url' => 'http://www.mediawiki.org/wiki/Extension:DeletePagePermanently',
);
 
# Default settings
$wgGroupPermissions['*']['deleteperm'] = false;
$wgGroupPermissions['user']['deleteperm'] = false;
$wgGroupPermissions['bureaucrat']['deleteperm'] = false;
$wgGroupPermissions['sysop']['deleteperm'] = true;
 
$wgDeletePagePermanentlyNamespaces = array (
        NS_IMAGE, NS_MEDIA, NS_FILE, NS_MAIN,

);
 
$wgExtensionMessagesFiles['DeletePagePermanently'] = dirname(__FILE__) . '/DeleteFilePermanently.i18n.php';
 
$wgExtensionFunctions[] = 'wfDeletePagePermanently';
 
function wfDeletePagePermanently() {
        new DeletePagePermanently();
        return true;
}
 
class DeletePagePermanently
{
        function DeletePagePermanently() {
                global $wgHooks, $wgExtensionMessagesFiles, $wgUser;
 
                wfLoadExtensionMessages('DeletePagePermanently');
 
                //$wgExtensionMessages->addMessage('delete_permanently', wfMsg('tab_label'));
                $wgHooks['SkinTemplateContentActions'][] = array (
                        &$this,
                        'AddContentHook'
                );
 
                $wgHooks['SkinTemplateNavigation'][] = array (
                        &$this,
                        'AddVectorHook'
                );
 
                $wgHooks['UnknownAction'][] = array (
                        &$this,
                        'AddActionHook'
                );
        }
 
        function AddContentHook(&$content_actions) {
                global $wgRequest, $wgRequest, $wgTitle, $wgUser, $wgDeletePagePermanentlyNamespaces;
 
                if (!$wgUser->isAllowed('deleteperm'))
                        return false;
 
                $action = $wgRequest->getText('action');
                
                // check for file namespace
                $isFileNS = false;
                if ( in_array( $wgTitle->getNamespace(), $wgDeletePagePermanentlyNamespaces ) )
                        $isFileNS = true;

                #Special pages can not be deleted (special pages have no article id anyway).
                if ($wgTitle->getArticleID() != 0 && $isFileNS == true
				&& $wgTitle->getNamespace() != NS_SPECIAL) {
                        wfLoadExtensionMessages('DeletePagePermanently');
 
                        $content_actions['ask_delete_permanently'] = array (
                                'class' => $action == 'ask_delete_permanently' ? 'selected' : false,
                                'text' => wfMsg('tab_label'),
                                'href' => $wgTitle->getLocalUrl('action=ask_delete_permanently')
                        );
                }
 
                return true;
        }
 
        function AddVectorHook(&$sktemplate, &$links) {
                global $wgRequest, $wgRequest, $wgTitle, $wgUser, $wgDeletePagePermanentlyNamespaces;
 
                if (!$wgUser->isAllowed('deleteperm'))
                        return false;
 
                $action = $wgRequest->getText('action');
 
                // check for file namespace
                $isFileNS = false;
                if ( in_array( $wgTitle->getNamespace(), $wgDeletePagePermanentlyNamespaces ) )
                        $isFileNS = true;

                #Special pages can not be deleted (special pages have no article id anyway).
                if ($wgTitle->getArticleID() != 0 && $isFileNS == true && $wgTitle->getNamespace() != NS_SPECIAL) {
                        wfLoadExtensionMessages('DeletePagePermanently');
 
                        $links['actions']['ask_delete_permanently'] = array (
                                'class' => $action == 'ask_delete_permanently' ? 'selected' : false,
                                'text' => wfMsg('delete_permanently'),
                                'href' => $wgTitle->getLocalUrl('action=ask_delete_permanently')
                        );
                }
 
                return true;
        }
 
        function AddActionHook($action, $wgArticle) {
                global $wgOut, $wgUser, $wgDeletePagePermanentlyNamespaces;
 
                wfLoadExtensionMessages('DeletePagePermanently');
 
                if (!$wgUser->isAllowed('deleteperm')) {
                        $wgOut->permissionRequired('deleteperm');
                        return false;
                }
 
                # Print a form to approve deletion
                if ($action == 'ask_delete_permanently') {
 
                        $action = $wgArticle->getTitle()->escapeLocalUrl() . "?action=delete_permanently";
                        $wgOut->addHTML("<form id='ask_delete_permanently' method='post' action=\"$action\">
<table>
        <tr>
                <td>" . wfMsg('ask_deletion') . "</td>
        </tr>
        <tr>
                <td><input type='submit' name='submit' value=\"" . wfMsg('yes') . "\" /></td>
        </tr>
</table></form>");
                        return false;
                }
                # Perform actual deletion
                elseif ($action == 'delete_permanently') {
                        $ns = $wgArticle->mTitle->getNamespace();
                        $t = $wgArticle->mTitle->getDBkey();
                        $id = $wgArticle->mTitle->getArticleID();

                        // check for file namespace
                        $isFileNS = false;
                        if ( in_array( $ns, $wgDeletePagePermanentlyNamespaces ) )
                                $isFileNS = true;
 
                        if ($t == '' || $id == 0 || $isFileNS != true || $ns == NS_SPECIAL) {
                                $wgOut->addHTML(wfMsgHtml('del_impossible'));
                                return false;
                        }
 
                        $this->deletePermanently($wgArticle->mTitle);
                        $wgOut->addHTML(wfMsgHtml('del_done'));
                        return false;
                }
                //$wgOut->addHTML(wfMsgHtml('del_not_done'));
                return true;
        }
 
        function deletePermanently($title) {
                global $wgOut;
 
                $ns = $title->getNamespace();
                $t = $title->getDBkey();
                $id = $title->getArticleID();
                $cats = $title->getParentCategories();
 
                $dbw = wfGetDB(DB_MASTER);
 
                $dbw->begin();
 
                ####
                ## First delete entries, which are in direct relation with the page:
                ####

                # delete redirect...
                $dbw->delete('redirect', array ('rd_from' => $id), __METHOD__);
 
                # delete external link...
                $dbw->delete('externallinks', array ('el_from' => $id), __METHOD__);
 
                # delete language link...
                $dbw->delete('langlinks', array ('ll_from' => $id), __METHOD__);
 
                # delete search index...
                $dbw->delete('searchindex', array ('si_page' => $id), __METHOD__);
 
                # Delete restrictions for the page
                $dbw->delete('page_restrictions', array ('pr_page' => $id), __METHOD__);
 
                # Delete page Links
                $dbw->delete('pagelinks', array ('pl_from' => $id), __METHOD__);
 
                # delete category links
                $dbw->delete('categorylinks', array ('cl_from' => $id), __METHOD__);
 
                # delete template links
                $dbw->delete('templatelinks', array ('tl_from' => $id), __METHOD__);
 
                # read text entries for all revisions and delete them.
                $res = $dbw->select('revision', 'rev_text_id', "rev_page=$id");
 
                while ($row = $dbw->fetchObject($res)) {
                        $value = $row->rev_text_id;
                        $dbw->delete('text', array ('old_id' => $value), __METHOD__);
                }
 
                # In the table 'revision' : Delete all the revision of the page where 'rev_page' = $id
                $dbw->delete('revision', array ('rev_page' => $id), __METHOD__);
 
                # delete image links
                $dbw->delete('imagelinks', array ('il_from' => $id), __METHOD__);
 
                ####
                ## then delete entries which are not in direct relation with the page:
                ####

                # Clean up recentchanges entries...
                $dbw->delete('recentchanges', array (
                        'rc_namespace' => $ns,
                        'rc_title' => $t
                ), __METHOD__);
 
                # read text entries for all archived pages and delete them.
                $res = $dbw->select('archive', 'ar_text_id', array (
                        'ar_namespace' => $ns,
                        'ar_title' => $t
                ));
 
                while ($row = $dbw->fetchObject($res)) {
                        $value = $row->ar_text_id;
                        $dbw->delete('text', array ('old_id' => $value), __METHOD__);
                }
 
                # Clean archive entries...
                $dbw->delete('archive', array (
                        'ar_namespace' => $ns,
                        'ar_title' => $t
                ), __METHOD__);
 
                # Clean up log entries...
                $dbw->delete('logging', array (
                        'log_namespace' => $ns,
                        'log_title' => $t
                ), __METHOD__);
 
                # Clean up watchlist...
                $dbw->delete('watchlist', array (
                        'wl_namespace' => $ns,
                        'wl_title' => $t
                ), __METHOD__);
 
                # In the table 'page' : Delete the page entry
                $dbw->delete('page', array ('page_id' => $id), __METHOD__);
 
                ####
                ## If the article belongs to a category, update category counts
                ####
                if (!empty($cats)) {
                        foreach ($cats as $parentcat => $currentarticle) {
                                //$catname = split(':', $parentcat, 2);		split is depricated, using explode instead
								$catname = explode(':', $parentcat, 2);
                                $cat = Category::newFromName($catname[1]);
                                $cat->refreshCounts();
                        }
                }
 
                ####
                ## If an image is beeing deleted, some extra work needs to be done
                ####
                if ($ns == NS_IMAGE) {
 
                        $file = wfFindFile($t);
 
                        if ($file) {
                                # Get all filenames of old versions:
                                $fields = OldLocalFile::selectFields();
                                $res = $dbw->select('oldimage', $fields, array ('oi_name' => $t));
 
                                while ($row = $dbw->fetchObject($res)) {
                                        $oldLocalFile = OldLocalFile::newFromRow($row, $file->repo);
                                        $path = $oldLocalFile->getArchivePath() . '/' . $oldLocalFile->getArchiveName();
 
                                        try { @unlink($path); }
                                        catch (Exception $e) { $wgOut->addHTML($e->getMessage()); }
                                }
 
                                $path = $file->getPath();
 
                                try {
                                        $file->purgeThumbnails();
                                        @unlink($path);
                                } catch (Exception $e) { $wgOut->addHTML($e->getMessage()); }
                        }
 
                        # clean the filearchive for the given filename:
                        $dbw->delete('filearchive', array ('fa_name' => $t), __METHOD__);
 
                        # Delete old db entries of the image:
                        $dbw->delete('oldimage', array ('oi_name' => $t), __METHOD__);
 
                        # Delete archive entries of the image:
                        $dbw->delete('filearchive', array ('fa_name' => $t), __METHOD__);
 
                        # Delete image entry:
                        $dbw->delete('image', array ('img_name' => $t), __METHOD__);
 
                        $dbw->commit();
 
                        $linkCache = LinkCache::singleton();
                        $linkCache->clear();
                }
        }
}