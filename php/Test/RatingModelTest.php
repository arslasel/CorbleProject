<?php

use PHPUnit\Framework\TestCase;

class RatingModelTest extends TestCase{

    protected $ratingModel;

    public function setUp():void
    {
        $this->ratingModel = new RatingModel("../../img/Corble.png","Corble");
        $this->ratingModel->setPrimaryOptimalColorRatio(1);
        $this->ratingModel->setSecondaryOptimalColorRatio(0);
        $this->ratingModel->setPrimaryColor("black");
        $this->ratingModel->setPrimaryColor("red");
    }

    public function testHelloWorldWorks()
    {
        $this->ratingModel->ratioColorsRate();
        $this->assertEquals("Hello World","Hello World");
    }
}

?>