<?php
	$langCode = array(
		"fr" => "fr_FR.utf8",
		"en" => "en_US"
		);
	//	
	if ($langCode[$lang])
		{
		putenv('LC_ALL='.$langCode[$lang]);
		setlocale(LC_ALL, $langCode[$lang]);
		bindtextdomain("cmsuno", dirname(__FILE__));
		textdomain("cmsuno");
		}
	if(file_exists(dirname(__FILE__).'/../extra/extra.php')) include(dirname(__FILE__).'/../extra/extra.php');
?>