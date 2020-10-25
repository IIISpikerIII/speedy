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
	 */
	public function run(TestInterface $object, $method, $size): TestResultDTO
	{
		xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
		call_user_func_array([$object, $method], [$size]);
		$xhprof_data = xhprof_disable();
		$data = $xhprof_data['main()'];

		if ($this->xhprof_lib !== false && $this->xhprof_runs !== false) {
			include_once $this->xhprof_lib;
			include_once $this->xhprof_runs;
			$xhprof_runs = new \XHProfRuns_Default();
			$run_id = $xhprof_runs->save_run($xhprof_data, $object->name);
		}

		return new TestResultDTO($data['mu'], $data['wt']);
	}
}