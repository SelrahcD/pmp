<?php

use Pmp\Domain\Model\Market\Url;

class UrlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function fromNative_returns_an_url()
    {
        $url = Url::fromNative('http://poney.fr');
        $this->assertInstanceOf('Pmp\Domain\Model\Market\Url', $url);
    }

    /**
     * @test
     */
    public function equals_returns_true_if_urls_are_equal()
    {
        $url1 = new Url('http://poney.fr');
        $url2 = new Url('http://poney.fr');
        $this->assertTrue($url1->equals($url2));
    }

    /**
     * @test
     */
    public function equals_return_false_if_urls_are_not_equal()
    {
        $url1 = new Url('http://poney.fr');
        $url2 = new Url('http://cheval.com');
        $this->assertFalse($url1->equals($url2));
    }

    /**
     * @test
     */
    public function toNative_returns_the_native_from_of_url()
    {
        $url = new Url('http://poney.fr');
        $this->assertEquals('http://poney.fr', $url->toNative());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function constructor_throws_InvalidArgumentException_if_unvalid_url_passed()
    {
        new Url('poney.fr');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function fromNative_throws_InvalidArgumentException_if_unvalid_url_passed()
    {
        Url::fromNative('poney.fr');
    }
}