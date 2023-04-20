<?php
$wgAutoloadClasses['tool'] = $IP . '/extensions/tool/tool_body.php';
$wgHooks['ParserFirstCallInit'][] = 'tool::onParserInit';
$wgResourceModules['ext.tool'] = array(
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'tool',
	'styles' => 'tool.css'
);

// :)
