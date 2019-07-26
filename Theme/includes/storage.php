<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('prolingua_storage_get')) {
	function prolingua_storage_get($var_name, $default='') {
		global $PROLINGUA_STORAGE;
		return isset($PROLINGUA_STORAGE[$var_name]) ? $PROLINGUA_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('prolingua_storage_set')) {
	function prolingua_storage_set($var_name, $value) {
		global $PROLINGUA_STORAGE;
		$PROLINGUA_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('prolingua_storage_empty')) {
	function prolingua_storage_empty($var_name, $key='', $key2='') {
		global $PROLINGUA_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($PROLINGUA_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($PROLINGUA_STORAGE[$var_name][$key]);
		else
			return empty($PROLINGUA_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('prolingua_storage_isset')) {
	function prolingua_storage_isset($var_name, $key='', $key2='') {
		global $PROLINGUA_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($PROLINGUA_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($PROLINGUA_STORAGE[$var_name][$key]);
		else
			return isset($PROLINGUA_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('prolingua_storage_inc')) {
	function prolingua_storage_inc($var_name, $value=1) {
		global $PROLINGUA_STORAGE;
		if (empty($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = 0;
		$PROLINGUA_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('prolingua_storage_concat')) {
	function prolingua_storage_concat($var_name, $value) {
		global $PROLINGUA_STORAGE;
		if (empty($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = '';
		$PROLINGUA_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('prolingua_storage_get_array')) {
	function prolingua_storage_get_array($var_name, $key, $key2='', $default='') {
		global $PROLINGUA_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($PROLINGUA_STORAGE[$var_name][$key]) ? $PROLINGUA_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($PROLINGUA_STORAGE[$var_name][$key][$key2]) ? $PROLINGUA_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('prolingua_storage_set_array')) {
	function prolingua_storage_set_array($var_name, $key, $value) {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if ($key==='')
			$PROLINGUA_STORAGE[$var_name][] = $value;
		else
			$PROLINGUA_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('prolingua_storage_set_array2')) {
	function prolingua_storage_set_array2($var_name, $key, $key2, $value) {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if (!isset($PROLINGUA_STORAGE[$var_name][$key])) $PROLINGUA_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$PROLINGUA_STORAGE[$var_name][$key][] = $value;
		else
			$PROLINGUA_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('prolingua_storage_merge_array')) {
	function prolingua_storage_merge_array($var_name, $key, $value) {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if ($key==='')
			$PROLINGUA_STORAGE[$var_name] = array_merge($PROLINGUA_STORAGE[$var_name], $value);
		else
			$PROLINGUA_STORAGE[$var_name][$key] = array_merge($PROLINGUA_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('prolingua_storage_set_array_after')) {
	function prolingua_storage_set_array_after($var_name, $after, $key, $value='') {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if (is_array($key))
			prolingua_array_insert_after($PROLINGUA_STORAGE[$var_name], $after, $key);
		else
			prolingua_array_insert_after($PROLINGUA_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('prolingua_storage_set_array_before')) {
	function prolingua_storage_set_array_before($var_name, $before, $key, $value='') {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if (is_array($key))
			prolingua_array_insert_before($PROLINGUA_STORAGE[$var_name], $before, $key);
		else
			prolingua_array_insert_before($PROLINGUA_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('prolingua_storage_push_array')) {
	function prolingua_storage_push_array($var_name, $key, $value) {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($PROLINGUA_STORAGE[$var_name], $value);
		else {
			if (!isset($PROLINGUA_STORAGE[$var_name][$key])) $PROLINGUA_STORAGE[$var_name][$key] = array();
			array_push($PROLINGUA_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('prolingua_storage_pop_array')) {
	function prolingua_storage_pop_array($var_name, $key='', $defa='') {
		global $PROLINGUA_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($PROLINGUA_STORAGE[$var_name]) && is_array($PROLINGUA_STORAGE[$var_name]) && count($PROLINGUA_STORAGE[$var_name]) > 0) 
				$rez = array_pop($PROLINGUA_STORAGE[$var_name]);
		} else {
			if (isset($PROLINGUA_STORAGE[$var_name][$key]) && is_array($PROLINGUA_STORAGE[$var_name][$key]) && count($PROLINGUA_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($PROLINGUA_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('prolingua_storage_inc_array')) {
	function prolingua_storage_inc_array($var_name, $key, $value=1) {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if (empty($PROLINGUA_STORAGE[$var_name][$key])) $PROLINGUA_STORAGE[$var_name][$key] = 0;
		$PROLINGUA_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('prolingua_storage_concat_array')) {
	function prolingua_storage_concat_array($var_name, $key, $value) {
		global $PROLINGUA_STORAGE;
		if (!isset($PROLINGUA_STORAGE[$var_name])) $PROLINGUA_STORAGE[$var_name] = array();
		if (empty($PROLINGUA_STORAGE[$var_name][$key])) $PROLINGUA_STORAGE[$var_name][$key] = '';
		$PROLINGUA_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('prolingua_storage_call_obj_method')) {
	function prolingua_storage_call_obj_method($var_name, $method, $param=null) {
		global $PROLINGUA_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($PROLINGUA_STORAGE[$var_name]) ? $PROLINGUA_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($PROLINGUA_STORAGE[$var_name]) ? $PROLINGUA_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('prolingua_storage_get_obj_property')) {
	function prolingua_storage_get_obj_property($var_name, $prop, $default='') {
		global $PROLINGUA_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($PROLINGUA_STORAGE[$var_name]->$prop) ? $PROLINGUA_STORAGE[$var_name]->$prop : $default;
	}
}
?>