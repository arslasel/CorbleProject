<?php

use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase{

    public function testHelloWorldWorks()
    {
        $this->assertEquals("Hello World","Hello World");
    }

    public function testHelloWorldFails()
    {
        $this->assertNotEquals("Hello World","");
    }
}

?>