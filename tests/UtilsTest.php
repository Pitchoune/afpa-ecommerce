<?php

define('DIR', getcwd());
require_once('./controller/Utils.php');

use PHPUnit\Framework\TestCase;

/**
 * Class to execute tests with PHPUnit
 */
class UtilsTest extends TestCase
{
	/**
	 * Verifies if the method return_bytes() in class Utils works correctly.
	 *
	 * @return void
	 */
	public function testreturn_bytes()
	{
		$this->assertEquals(2097152, Utils::return_bytes(ini_get('upload_max_filesize')));
		$this->assertEquals(2097152, Utils::return_bytes('2M'));
	}
}

?>