<?php

namespace MediaWiki\Hook;

/**
 * @stable for implementation
 * @ingroup Hooks
 */
interface SoftwareInfoHook {
	/**
	 * Called by Special:Version for returning information about the
	 * software.
	 *
	 * @since 1.35
	 *
	 * @param ?mixed &$software The array of software in format 'name' => 'version'. See
	 *   SpecialVersion::softwareInformation().
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSoftwareInfo( &$software );
}