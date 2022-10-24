<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Controller\ApiController;

final class ApiControllerTest extends TestCase
{
    public function testControl() {
        $this->assertEquals(true,true);
    }

    public function testCheckdate() {
        $apiController = new ApiController();
        $this->assertEquals(
            true,
            $this->invokeMethod($apiController,'checkdate',['2022-12-01'])
        );
        $this->assertEquals(
            true,
            $this->invokeMethod($apiController,'checkdate',['2022-12-31'])
        );
        $this->assertEquals(
            false,
            $this->invokeMethod($apiController,'checkdate',['2022-12-32'])
        );
        $this->assertEquals(
            false,
            $this->invokeMethod($apiController,'checkdate',['2022-13-01'])
        );
    }

    /**
     * This method is to test private methods of a class
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array()) { //https://www.jordonbrill.com/2015/testing-private-methods-in-phpunit/
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
    
}
