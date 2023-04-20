<?php
class tool {
	static function onParserInit( Parser $parser ) {
		$parser->setHook( 'tool', array( __CLASS__, 'toolRender' ) );
		return true;
	}
	static function toolRender( $text, array $args, Parser $parser, PPFrame $frame ) {
		$github = 'https://github.com';
		$user = $args['user'];
		$repo = $args['repo'];
		$file = $args['file'];

		$url = $github . '/' . $user . '/' . $repo;
        
		$text = '{{#github:' . $file . '|' . $user . '/' . $repo . '}}';
		$jeroen = $parser->recursiveTagParse( $text, $frame );
        
//        $text2 = '{{Special:WhatLinksHere/ James Bryan Graves}}';
//        $text2 = '{{Special:WhatLinksHere/ ' . $repo . '}}';
//        $alsoin = $parser->recursiveTagParse( $text2, $frame );

		$ret = '<tool>';
		$ret .= '<div class="tool">';
		$ret .= "<div class='toolHeader'><a href='{$github}/{$user}' target='_blank'>{$user}</a> / <a href='{$github}/{$user}/{$repo}' target='_blank'>{$repo}</a> / {$file}</div>";
		$ret .= "<div class='toolContent'>{$jeroen}</div>";
		$ret .= '<div class="toolFooter">';
		$ret .= '<a href="https://hackersanddesigners.nl/s/Tools">↗ view more tools ↗</a>';
		$ret .= '<a class="inGitHub" href="' . $url . '" target="_blank">↗ view in GitHub ↗</a>';
		$ret .= '</div>';
		$ret .= '</div>';
//		$ret .= "<div class='alsoIn'><p>Also appears in:</p><p>" . $alsoin . "</p></div>";
		$ret .= '</tool>';

		$parser->getOutput()->addModules( 'ext.tool' );

		return $ret;
	}
}
