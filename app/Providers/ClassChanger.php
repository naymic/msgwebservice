<?php

namespace MessageWebService\Providers;

use MessageWebService\JRequest\JsonRequest;

class ClassChanger {
	/**
	 * Change the class of an object
	 *
	 * @param object $obj        	
	 * @param string $class_type        	
	 * @author toma at smartsemantics dot com
	 * @see http://www.php.net/manual/en/language.types.type-juggling.php#50791
	 */
	public static function changeClass(&$obj, $new_class): JsonRequest {
		if (class_exists ( $new_class, true )) {
			$obj = unserialize ( preg_replace ( "/^O:[0-9]+:\"[^\"]+\":/i", "O:" . strlen ( $new_class ) . ":\"" . $new_class . "\":", serialize ( $obj ) ) );
		}
		return $obj;
	}
}

?>