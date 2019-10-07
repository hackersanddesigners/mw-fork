<?php

namespace MediaWiki\Tests\Message;

use MediaWiki\Message\TextFormatter;
use MediaWikiTestCase;
use Message;
use Wikimedia\Message\MessageValue;
use Wikimedia\Message\ParamType;
use Wikimedia\Message\ScalarParam;

/**
 * @covers \MediaWiki\Message\TextFormatter
 * @covers \Wikimedia\Message\MessageValue
 * @covers \Wikimedia\Message\ListParam
 * @covers \Wikimedia\Message\ScalarParam
 * @covers \Wikimedia\Message\MessageParam
 */
class TextFormatterTest extends MediaWikiTestCase {
	private function createTextFormatter( $langCode ) {
		$formatter = $this->getMockBuilder( TextFormatter::class )
			->setConstructorArgs( [ $langCode ] )
			->setMethods( [ 'createMessage' ] )
			->getMock();
		$formatter->method( 'createMessage' )
			->willReturnCallback( function ( $key ) {
				$message = $this->getMockBuilder( Message::class )
					->setConstructorArgs( [ $key ] )
					->setMethods( [ 'fetchMessage' ] )
					->getMock();

				$message->method( 'fetchMessage' )
					->willReturnCallback( function () use ( $message ) {
						/** @var Message $message */
						return "{$message->getKey()} $1 $2";
					} );

				return $message;
			} );

		/** @var TextFormatter $formatter */
		return $formatter;
	}

	public function testGetLangCode() {
		$formatter = new TextFormatter( 'fr' );
		$this->assertSame( 'fr', $formatter->getLangCode() );
	}

	public function testFormatBitrate() {
		$formatter = $this->createTextFormatter( 'en' );
		$mv = ( new MessageValue( 'test' ) )->bitrateParams( 100, 200 );
		$result = $formatter->format( $mv );
		$this->assertSame( 'test 100 bps 200 bps', $result );
	}

	public function testFormatList() {
		$formatter = $this->createTextFormatter( 'en' );
		$mv = ( new MessageValue( 'test' ) )->commaListParams( [
			'a',
			new ScalarParam( ParamType::BITRATE, 100 ),
		] );
		$result = $formatter->format( $mv );
		$this->assertSame( 'test a, 100 bps $2', $result );
	}

	public function testFormatMessage() {
		$formatter = $this->createTextFormatter( 'en' );
		$mv = ( new MessageValue( 'test' ) )
			->params( new MessageValue( 'test2', [ 'a', 'b' ] ) )
			->commaListParams( [
				'x',
				new ScalarParam( ParamType::BITRATE, 100 ),
				new MessageValue( 'test3', [ 'c', new MessageValue( 'test4', [ 'd', 'e' ] ) ] )
			] );
		$result = $formatter->format( $mv );
		$this->assertSame( 'test test2 a b x, 100 bps, test3 c test4 d e', $result );
	}
}
