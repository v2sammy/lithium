<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\tests\cases\console\command\build;

use \lithium\console\command\build\Controller;
use \lithium\console\Request;
use \lithium\core\Libraries;

class ControllerTest extends \lithium\test\Unit {

	public $request;

	protected $_backup = array();

	protected $_testPath = null;

	public function setUp() {
		$this->classes = array('response' => '\lithium\tests\mocks\console\MockResponse');
		$this->_backup['cwd'] = getcwd();
		$this->_backup['_SERVER'] = $_SERVER;
		$_SERVER['argv'] = array();
		$this->_testPath = LITHIUM_APP_PATH . '/resources/tmp/tests';

		Libraries::add('build_test', array('path' => $this->_testPath . '/build_test'));
		$this->request = new Request(array('input' => fopen('php://temp', 'w+')));
		$this->request->params = array('library' => 'build_test');
	}

	public function tearDown() {
		$_SERVER = $this->_backup['_SERVER'];
		chdir($this->_backup['cwd']);
		$this->_cleanUp();
	}

	public function testRun() {
		$controller = new Controller(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$controller->path = $this->_testPath;
		$controller->run('Posts');
		$expected = "PostsController created in build_test\\controllers.\n";
		$result = $controller->response->output;
		$this->assertEqual($expected, $result);

		$expected = <<<'test'


namespace build_test\controllers;

use \build_test\models\Post;

class PostsController extends \lithium\test\Unit {



}


test;
		$replace = array("<?php", "?>");
		$result = str_replace($replace, '',
			file_get_contents($this->_testPath . '/build_test/controllers/PostsController.php')
		);
		$this->assertEqual($expected, $result);
	}
}

?>