<?php

class YiiDebugToolbarTest extends CTestCase
{
    public function testYiiDebugToolbarRoute()
    {
        $routeObject = new YiiDebugToolbarRoute();
        $this->assertNull($routeObject->getStartTime());
        $this->assertNull($routeObject->getEndTime());
        $this->assertNull($routeObject->init());
        $this->assertRegExp('/\d{1,}/', (string)$routeObject->getStartTime());


        $this->assertNotNull(self::getMethod('YiiDebugToolbarRoute','getToolbarWidget')
             ->invokeArgs($routeObject, array()));

        $this->assertNull(self::getMethod('YiiDebugToolbarRoute','onBeginRequest')
             ->invokeArgs($routeObject, array(new CEvent(Yii::app()))));

        $this->assertNull(self::getMethod('YiiDebugToolbarRoute','onEndRequest')
             ->invokeArgs($routeObject, array(new CEvent(Yii::app()))));

        $allowIpMethod = self::getMethod('YiiDebugToolbarRoute','allowIp');
        $this->assertEquals(true, $allowIpMethod->invokeArgs($routeObject, array('127.0.0.1')));
        $this->assertEquals(false, $allowIpMethod->invokeArgs($routeObject, array('127.0.0.2')));

        $this->assertNull($routeObject->collectLogs(new CLogger, false));

    }


    public function testYiiDebugToolbar()
    {

    }

    protected static function getMethod($class,$name)
    {
        $class = new ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

}