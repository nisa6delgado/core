<?php

/**
 * Get var of the config file.
 *
 * @param  string $var
 * @return string
 */

function config($var1, $var2 = '')
{
	$config = require($_SERVER['DOCUMENT_ROOT'] '/app/config.php');
	
	if (isset($var2) && $var2 != '') {
		return $config[$var1][$var2];
	}

	return $config[$var1];
}