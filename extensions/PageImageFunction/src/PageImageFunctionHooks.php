<?php
class PageImageFunctionHooks {
   public static function onParserFirstCallInit( Parser $parser ) {
      $parser->setFunctionHook( 'example', [ self::class, 'renderExample' ] );
   }
   public static function renderExample( Parser $parser, $param1 = '') {
      $output = "Page iamge filename is $param1";

      return $output;
   }
}
