Installation

   1. Create a new folder (directory) in the following location:
      wiki-install-folder/extensions/googleAnalytics
   2. Download the googleAnalytics.php files from SVN
   3. Copy googleAnalytics.php and googleAnalytics.i18n.php in to the new googleAnalytics folder
      Note: you may need to remove the pageTracker._initData(); line from googleAnalytics.php for Analytics to recognise the installation
   4. Add the following line to your LocalSettings.php at the bottom:

require_once( "$IP/extensions/googleAnalytics/googleAnalytics.php" );

In the googleAnalytics folder, googleAnalytics.php you can find the following and edit as appropriate:

# Replace xxxxxxx-x with YOUR GoogleAnalytics UA number
$wgGoogleAnalyticsAccount = "UA-xxxxxxx-x";
 
# Optional Variables (both default to true)
$wgGoogleAnalyticsIgnoreSysops = false;
$wgGoogleAnalyticsIgnoreBots = false;
#If you use AdSense as well and have linked your accounts, to enable tracking set this to true
$wgGoogleAnalyticsAddASAC = false;

Charles de Grasse GA account
UA-8119573-3