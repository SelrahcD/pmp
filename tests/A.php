<?php
use Pmp\Infrastructure\Annotations\Loggable;

class A {

    private $b;

    /**
     * @Loggable
     */
    public function hop()
    {
        echo 'BBB';
    }
}