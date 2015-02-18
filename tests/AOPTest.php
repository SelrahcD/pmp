<?php

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Doctrine\Common\Annotations\AnnotationRegistry;

class AOPTest extends TestCase {

    public function setUp()
    {
        $this->createApplication();

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


