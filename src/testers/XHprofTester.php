<?php

namespace speedy\testers;

use speedy\DTO\TestResultDTO;
use speedy\tests\interfaces\TestInterface;

class XHprofTester implements TesterInterface
{
	public $xhprof_lib = false;
	public $xhprof_runs = false;

	/**
	 * @param TestInterface $object
	 * @param string $method
	 * @param int $size
	 *
	 * @return TestResultDTO
	 * @throws \Exception
	 */
	public function run(TestInterface $object, string $method, int$size): TestResultDTO
	{
		if (extension_loaded('xhprof') === false) {
			throw new \Exception("Extension xhprof not loaded");
		}

		xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
		$object->$method($size);
		$xhprof_data = xhprof_disable();
		$data = $xhprof_data['main()'];

		if ($this->xhprof_lib !== false && $this->xhprof_runs !== false) {
			include_once $this->xhprof_lib;
			include_once $this->xhprof_runs;
			$xhprof_runs = new \XHProfRuns_Default();
			$xhprof_runs->save_run($xhprof_data, $object->name);
		}

		return new TestResultDTO($data['mu'], $data['wt']);
	}
}