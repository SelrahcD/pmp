<?php

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Infrastructure\Aop\ApplicationAspectKernel;
use Doctrine\Common\Annotations\AnnotationRegistry;

class AOPTest extends TestCase {

    public function setUp()
    {
        $this->createApplication();

        $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        $applicationAspectKernel->init(array(
        'debug' => true, // use 'false' for production mode
        // Cache directory
        'cacheDir'  => __DIR__ . '/../storage/framework/cache/aop',
        // Include paths restricts the directories where aspects should be applied, or empty for all source files
        'includePaths' => array(
            __DIR__ . '/../app/Domain/',
            __DIR__
        )
        ));

        AnnotationRegistry::registerFile(__DIR__ . '/../app/Infrastructure/Annotations/Loggable.php');
    }

    /**
     * @test
     */
    public function bla()
    {
        $a = new A;
        $a->hop();
    }

}


