<?php
declare(strict_types = 1);

namespace Queue\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Queue\Command\MigrateTasksCommand;
use Shim\TestSuite\TestTrait;

/**
 * @uses \Queue\Command\MigrateTasksCommand
 */
class MigrateTasksCommandTest extends TestCase {

	use ConsoleIntegrationTestTrait;
	use TestTrait;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->useCommandRunner();
	}

	/**
	 * @return void
	 */
	public function testMigrateTask(): void {
		$path = sys_get_temp_dir() . DS . 'FooTask.php';
		$params = [
			'Foo',
			null,
			ROOT . DS . 'tests' . DS . 'test_files' . DS . 'migrate' . DS . 'QueueFooTask.php',
			$path,
		];
		$command = new MigrateTasksCommand();
		$this->invokeMethod($command, 'migrateTask', $params);

		$expected = ROOT . DS . 'tests' . DS . 'test_files' . DS . 'migrate' . DS . 'FooTask.php';
		$this->assertFileEquals($expected, $path);
	}

	/**
	 * @return void
	 */
	public function testMigrateTaskPlugin(): void {
		$path = sys_get_temp_dir() . DS . 'FooPluginTask.php';
		$params = [
			'Foo',
			'Foo/Bar',
			ROOT . DS . 'tests' . DS . 'test_files' . DS . 'migrate' . DS . 'QueueFooPluginTask.php',
			$path,
		];
		$command = new MigrateTasksCommand();
		$this->invokeMethod($command, 'migrateTask', $params);

		$expected = ROOT . DS . 'tests' . DS . 'test_files' . DS . 'migrate' . DS . 'FooPluginTask.php';
		$this->assertFileEquals($expected, $path);
	}

	/**
	 * Test execute method
	 *
	 * @return void
	 */
	public function testExecute(): void {
		$this->exec('queue migrate_tasks');

		$output = $this->_out->messages();
		dd($output);
	}

}
