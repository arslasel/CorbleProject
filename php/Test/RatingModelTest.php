<?php

use PHPUnit\Framework\TestCase;

class RatingModelTest extends TestCase{

    protected $ratingModel;

    public function setUp():void
    {

    }

    public function testHelloWorldWorks()
    {
        $stub = $this->createMock(CorbleDatabase::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->ratingModel->setPrimaryOptimalColorRatio(1);
        $this->ratingModel->setSecondaryOptimalColorRatio(0);
        $this->ratingModel->setPrimaryColor("black");
        $this->ratingModel->setPrimaryColor("red");
        $this->ratingModel->ratioColorsRate();
        $this->assertEquals("Hello World","Hello Wforld");
    }
}

?>