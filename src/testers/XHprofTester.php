<?php
namespace speedyPack\testers;

use speedyPack\interfaces\TestCore;
use speedyPack\interfaces\TesterInterface;

class XHprofTester implements TesterInterface
{
    public $xhprof_lib = false;
    public $xhprof_runs = false;

    public function run(TestCore $object, $method, $size)
    {
        xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
        call_user_func_array([$object, $method], [$size]);
        $xhprof_data = xhprof_disable();
        $data = $xhprof_data['main()'];

        if($this->xhprof_lib !== false && $this->xhprof_runs !== false) {
            include_once $this->xhprof_lib;
            include_once $this->xhprof_runs;
            $xhprof_runs = new \XHProfRuns_Default();
            $run_id = $xhprof_runs->save_run($xhprof_data, $object->name);
        }

        return ['memory' => $data['mu'], 'time' => $data['wt']];
    }
}