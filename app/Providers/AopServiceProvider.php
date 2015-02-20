<?php namespace Pmp\Providers;

use Illuminate\Support\ServiceProvider;
use Pmp\Infrastructure\Aop\ApplicationAspectKernel;
use Config;

class AopServiceProvider extends ServiceProvider {

    public function register()
    {
        $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        $applicationAspectKernel->init(Config::get('aop'));
    }

}
