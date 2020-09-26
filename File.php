<?php

namespace phputils;

use DateTime;
use \ReflectionException;

class File {

	static function open($file) {
		return file_get_contents($_SERVER["DOCUMENT_ROOT"] . $file);
	}
}
