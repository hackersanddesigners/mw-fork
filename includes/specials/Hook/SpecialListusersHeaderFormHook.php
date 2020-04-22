<?php

namespace MediaWiki\Hook;

/**
 * @stable for implementation
 * @ingroup Hooks
 */
interface SpecialListusersHeaderFormHook {
	/**
	 * Called before adding the submit button in
	 * UsersPager::getPageHeader().
	 *
	 * @since 1.35
	 *
	 * @param ?mixed $pager The UsersPager instance
	 * @param ?mixed &$out The header HTML
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSpecialListusersHeaderForm( $pager, &$out );
}