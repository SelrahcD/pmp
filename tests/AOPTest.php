<?php

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Infrastructure\Aop\ApplicationAspectKernel;

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
            __DIR__ . '/../app/Domain/'
        )
        ));
    }

    public function tearDown()
    {
        
    }

    /**
     * @test
     */
    public function bla()
    {
        // $a = new Agency(new Name('AAA'));
        // $a->isReferencedOn(new Market(new Url('http://poney.fr')));
    }

}
