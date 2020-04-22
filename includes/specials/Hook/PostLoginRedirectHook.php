<?php

namespace MediaWiki\Hook;

/**
 * @stable for implementation
 * @ingroup Hooks
 */
interface PostLoginRedirectHook {
	/**
	 * Modify the post login redirect behavior.
	 * Occurs after signing up or logging in, allows for interception of redirect.
	 *
	 * @since 1.35
	 *
	 * @param ?mixed &$returnTo The page name to return to, as a string
	 * @param ?mixed &$returnToQuery array of url parameters, mapping parameter names to values
	 * @param ?mixed &$type type of login redirect as string;
	 *   error: display a return to link ignoring $wgRedirectOnLogin
	 *   signup: display a return to link using $wgRedirectOnLogin if needed
	 *   success: display a return to link using $wgRedirectOnLogin if needed
	 *   successredirect: send an HTTP redirect using $wgRedirectOnLogin if needed
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onPostLoginRedirect( &$returnTo, &$returnToQuery, &$type );
}