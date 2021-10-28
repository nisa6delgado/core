<?php

/**
 * Get var of the config file.
 *
 * @param  string $var
 * @return string|object
 */

function config($var)
{
	if (isset($_ENV[$var]) && $_ENV[$var] != '') {
		if (is_array($_ENV[$var])) {
			return (object) $_ENV[$var];
		}

		return $_ENV[$var];
	}
}