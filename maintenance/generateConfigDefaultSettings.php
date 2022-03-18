<?php

use Wikimedia\StaticArrayWriter;

require_once __DIR__ . '/Maintenance.php';
require_once __DIR__ . '/includes/ConfigSchemaDerivativeTrait.php';

/**
 * Maintenance script that generates a DefaultSettings.php file,
 * for backwards compatibility and as documentation stub.
 *
 * @ingroup Maintenance
 */
class GenerateConfigDefaultSettings extends Maintenance {
	use ConfigSchemaDerivativeTrait;

	/** @var string */
	private const DEFAULT_OUTPUT_PATH = __DIR__ . '/../includes/DefaultSettings.php';

	/** @var array */
	private const NORMALIZE_PHP_TYPES = [
		'object' => 'array',
		'number' => 'float',
		'double' => 'float',
		'boolean' => 'bool',
		'integer' => 'int',
		'null' => null,
	];

	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Generate the DefaultSettings.php file.' );
		$this->addOption(
			'output',
			'Path to output relative to $IP. Default: ' . self::DEFAULT_OUTPUT_PATH,
			false,
			true
		);
	}

	public function execute() {
		$input = $this->loadSettingsSource();
		$code = '';
		// Details about each config variable
		foreach ( $input['config-schema'] as $configKey => $configSchema ) {
			$code .= "\n";
			$code .= $this->getVariableDeclaration( $configKey, $configSchema );
		}

		$newContent = $this->processTemplate( MW_INSTALL_PATH . '/includes/DefaultSettings.template', $code );

		$this->writeOutput( self::DEFAULT_OUTPUT_PATH, $newContent );
	}

	/**
	 * @param string $name
	 * @param array $schema
	 *
	 * @return string
	 */
	private function getVariableDeclaration( string $name, array $schema ): string {
		$doc = [];
		$docType = null;
		if ( isset( $schema['type'] ) ) {
			$docType = $this->jsonTypeToDoc( $schema['type'] );
		}

		$doc[] = "Variable for the $name setting, for use in LocalSettings.php";
		$doc[] = "@see MainConfigSchema::$name";
		$doc[] = "@note Do not change manually, " .
			"generated by maintenance/generateConfigDefaultSettings.php!";

		if ( isset( $schema['since'] ) ) {
			$doc[] = "@since {$schema['since']}";
		}
		if ( isset( $schema['deprecated'] ) ) {
			$doc[] = "@deprecated {$schema['deprecated']}";
		}
		if ( $docType ) {
			$doc[] = "@var $docType";
		}

		$code = "/**\n * ";
		$code .= implode( "\n * ", $doc );
		$code .= "\n */\n";

		$value = StaticArrayWriter::encodeValue( $schema['default'] ?? null );
		$code .= "\$wg{$name} = {$value};\n";

		return $code;
	}

	private function jsonTypeToDoc( $type ) {
		if ( is_array( $type ) ) {
			$type = array_map( [ $this, 'jsonTypeToDoc' ], $type );
			return implode( '|', $type );
		}
		$type = strtolower( $type );
		$type = self::NORMALIZE_PHP_TYPES[$type] ?? $type;
		return $type ?: 'mixed';
	}
}

$maintClass = GenerateConfigDefaultSettings::class;
require_once RUN_MAINTENANCE_IF_MAIN;
