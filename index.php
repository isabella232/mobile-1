<?php  																														require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/system/app.class.php");	require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/system/nav.class.php"); 	require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/system/menu.class.php"); 	$App 	= new App();	$Nav	= new Nav();	$Menu 	= new Menu();		include("_projectCommon.php");    # All on the same line to unclutter the user's desktop'
$documentRoot = $_SERVER['DOCUMENT_ROOT'];

$defaultPath = ($App->devmode == TRUE) ? $_SERVER['DOCUMENT_ROOT'] . '/downloads-xml/' : '/home/data/httpd/writable/community/';
if (!isset($_GET['osType'])) {
	$osDisplay = $App->getClientOS();
}
else {
	$osDisplay = $_GET['osType'];
}
$packages = array();
$packages['Windows'] = array('packagesDetails' => "releaseCacheWin.xml" );
$packages['Linux'] = array( 'packagesDetails' => "releaseCacheLinux.xml" );
$packages['Mac OS X'] = array('packagesDetails' => "releaseCacheCocoa.xml" );
$packages['carbon'] = array('packagesDetails' => "releaseCacheCarbon.xml" );
switch ($osDisplay) {
	case "win32":
		$display = "Windows";
		break;
	case "win64":
		$display = "Windows";
		break;
	case "linux":
		$display = "Linux";
		//$osWarning = "<b>Linux users please note:</b> Eclipse on GCJ is untested.  Please see the Linux <a href='http://wiki.eclipse.org/SDK_Known_Issues#Linux_issues'>Known Issues</a> document.<br />";
		break;
	case "linux-x64":
		$display = "Linux";
		//$osWarning = "<b>Linux users please note:</b> Eclipse on GCJ is untested.  Please see the Linux <a href='http://wiki.eclipse.org/SDK_Known_Issues#Linux_issues'>Known Issues</a> document.<br />";
		break;
	case "macosx":
		$display = "Mac OS X";
		break;
	case "carbon";
	$display = "Mac OS X";
	break;
	case "cocoa64":
		$display = "Mac OS X";
		break;
	default:
		$display = "Windows";
		//$packagesDetails = $documentRoot . "/downloads/content/heliosCacheWin.xml";
		break;
}

	#*****************************************************************************
	#
	# index.php (/mobile)
	#
	# Author: 		Christopher Guindon
	# Date:			2012-09-24
	#
	# Description: Mobile Package Landing Page
	#
	#
	#****************************************************************************
	
	#
	# Begin: page-specific settings.  Change these. 
	$pageTitle 		= "Eclipse for Mobile Developers";
	$pageKeywords	= "eclipse mobile, download mobile eclipse, eclipse mobike package";
	$pageAuthor		= "Christopher Guindon";
	
	# Add page-specific Nav bars here
	# Format is Link text, link URL (can be http://www.someothersite.com/), target (_self, _blank), level (1, 2 or 3)
	# $Nav->addNavSeparator("My Page Links", 	"downloads.php");
	# $Nav->addCustomNav("My Link", "mypage.php", "_self", 1);
	# $Nav->addCustomNav("Google", "http://www.google.com/", "_blank", 1);

	# End: page-specific settings
	#
	// This file is linked to from lots of different places.
	// Use absolute paths to make sure that we can actually test
	// that the file renders properly (i.e. testing using) "/index.php",
	// and "/home/index.php" both work.
	//include ('scripts/whatsnew.php');
	//$whatsnew = rss_to_html('whatsnew');			
	# Paste your HTML content between the EOHTML markers!
	function mobile_create_link($value, $key, $class = 'other-downloads'){
		$return = "";
		$os = $key;
		$return = array();
		foreach($value['url'] as $k => $v){		
			$return[] = '<a href="' . $v .'" class="downloadnow ' . $class . '">' . $key .' ' .$k . '</a>';			
		}
		return $return;
	}
	
	$downloads = array();
	foreach($packages as $key => $value){
			$xml = simplexml_load_file($defaultPath . $packages[$key]['packagesDetails']);			
			foreach ($xml->package as $package) {
				if($package['name'] == 'Eclipse for Mobile Developers'){
					$downloads[$key] = array('icon' => $package['icon'], 'url' => array('32 bit' => $package['downloadurl'], '64 bit' => $package['downloadurl64']));
					break;
				}
			}			
	}
	//print_r($downloads);
	ob_start();
	
	?>
	
<div id="maincontent">
	<div id="midcolumn">
		<h1 class="title-icon" style="background: url('<?php print $downloads[$display]['icon']?>') no-repeat;"><?php print $pageTitle;?></h1>
<br>
<p>The essential starting point for Mobile developers, including a Java IDE, C language support, a Git client, XML Editor and Mylyn.</p>
<div class="descriptionOS">
					<span id="descriptionText">Eclipse Juno (4.2) SR1 Mobile Package</span> for 
					<select id="osSelect">
<option <?php if ($osDisplay == 'win32') echo "selected"?> value="win32">Windows</option>
<option <?php if ($osDisplay == 'linux' || $osDisplay == 'linux-x64') echo "selected"?> value="linux">Linux</option>
<option <?php if ($osDisplay == 'macosx') echo "selected"?> value="macosx">Mac OS X (Cocoa)</option>
					</select>
				</div>

		<div id="main_downloads">
		<?php 
		$other_downloads = array();
		foreach($downloads as $key => $value){ 
				if($key == $display){		
					print implode('', mobile_create_link($value, $key, 'master-downloads'));	
		 		}else{
					$other_downloads[$key] = mobile_create_link($value, $key);	
				}
		}
		 ?>
		 <div id="other_download_div">
		 	<h3>Other Platform</h3>

	<?php 
		$x = 0;
		foreach($other_downloads as $k => $v){
			$x++;
			print '<div class="other_down" id="other_down_' . $x . '"><h4>' . $k . '</h4><ul class="list-other-downloads">';
			
			foreach($v as $link){
				
				print '<li>' . $link . '</li>';
			}
			print '</div></ul>';
		}
	?>
	</div>
		</div>	
	</div>

	<!-- remove the entire <div> tag to omit the right column!  -->
	<div id="rightcolumn" class="clearfix">
			<div class="rightContent">

		
	<h3>Installing Eclipse</h3>
	<ul id="installingEclipse">
		<li><a href="http://wiki.eclipse.org/Eclipse/Installation">Install Guide</a></li>
		<li><a href="compare.php">Compare/Combine Packages</a></li>
		<li><a href="http://wiki.eclipse.org/SDK_Known_Issues">Known Issues</a></li>
		<li><a href="http://help.eclipse.org/juno/index.jsp?topic=/org.eclipse.platform.doc.user/tasks/tasks-129.htm">Updating Eclipse</a></li>
	</ul>	
				
		
						
	<!--  <h3>Related Links</h3>
	<ul id="relatedLinks">
		 <li><a href="http://wiki.eclipse.org/CVS_Howto">Source Code</a></li> 
		<li><a href="http://help.eclipse.org">Documentation</a></li>
		<li><a href="/donate/">Make a Donation</a></li>
		<li><a href="/forums/">Forums</a></li>
		<li><a href="/juno/">Eclipse Juno (4.2)</a></li>
		<li><a href="/indigo/">Eclipse Indigo (3.7)</a></li>
		<li><a href="http://wiki.eclipse.org/Older_Versions_Of_Eclipse">Older Versions</a></li>
	</ul>
-->
	<h3 class="">Hint:</h3>
	<p class="jre">You will need a <a href="/downloads/moreinfo/jre.php">Java runtime environment (JRE)</a> to use Eclipse (Java SE 6 or greater is recommended). All downloads are provided under the terms and conditions of the <a href="/legal/epl/notice.php">Eclipse Foundation Software User Agreement</a> unless otherwise specified.</p>			

</div>
			
		</div>

</div>
<?php 
$html = ob_get_clean();
		 $App->AddExtraHtmlHeader('<link rel="stylesheet" type="text/css" href="mobile.css" media="screen" /><script type="text/javascript" src="http://www.eclipse.org/forums/js/jquery.js"></script><script type="text/javascript" src="/downloads/content/helios.js"></script>');
		$App->generatePage('Nova', $Menu, $Nav, $pageAuthor, $pageKeywords, $pageTitle, $html);
		