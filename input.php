<?php

/**
 * Checked checkbox if key is like value.
 *
 * @param  string|array $key
 * @param  string $value
 * @return string
 */
function checked($key, $value)
{
    if (is_array($key)) {
        foreach ($key as $item) {
            if ($item == $value) {
                echo 'checked';
            }
        }
    } else {
        echo (isset($key) && $key == $value) ? 'checked' : '';
    }
}

/**
 * Selected select if key is like value.
 *
 * @param  string|array $key
 * @param  string       $value
 * @return void
 */
function selected($key, $value)
{
    if (is_array($key)) {
        foreach ($key as $item) {
            if ($item == $value) {
                echo 'selected';
            }
        }
    } else {
        echo (isset($key) && $key == $value) ? 'selected' : '';
    }
}
