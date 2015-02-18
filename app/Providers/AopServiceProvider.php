<?php namespace Pmp\Providers;

use Illuminate\Support\ServiceProvider;
use Pmp\Infrastructure\Aop\ApplicationAspectKernel;
use Config;

class AopServiceProvider extends ServiceProvider {

    public function register()
    {
        $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        $applicationAspectKernel->init(array(
            'debug' => Config::get('aop.debug'), // use 'false' for production mode
            // Cache directory
            'cacheDir'  => Config::get('aop.cache'),
            // Include paths restricts the directories where aspects should be applied, or empty for all source files
            'includePaths' => Config::get('aop.includePaths')
        ));
    }

}
