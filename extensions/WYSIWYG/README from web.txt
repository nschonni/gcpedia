Extract the zip-file (wysiwyg-1.4.0_0.zip)
Copy the folder wysiwyg-1.4.0_0\extensions\WYSIWYG into the folder ..\htdocs\mediawiki\extensions
Add the following line to your LocalSettings.php to initialize the extension:
require_once("$IP/extensions/WYSIWYG/WYSIWYG.php");
Define the group rights, the easiest is to grant all users access:
$wgGroupPermissions['*']['wysiwyg']=true;
or only for registeres users:

$wgGroupPermissions['registered_users']['wysiwyg']=true;
Now the WYSIWYG Extension is installed and ready to use.