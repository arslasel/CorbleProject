<?php

use PHPUnit\Framework\TestCase;

class RatingModelTest extends TestCase{

    protected $ratingModel;

    public function setUp():void
    {
        /* 
            $stub = $this->createMock(CorbleDatabase::class);
            $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        */
    }

    public function test_PointValidation()
    {
        $stub = $this->createMock(CorbleDatabase::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(-10, $this->ratingModel->validatePenaltiePoints(-10)); //good
        $this->assertEquals(1,$this->ratingModel->validatePenaltiePoints(1)); //good
        $this->assertEquals(5,$this->ratingModel->validatePenaltiePoints(5)); //good
        $this->assertEquals(RatingModel::MAX_POINTS, $this->ratingModel->validatePenaltiePoints(19)); //bad
        $this->assertEquals(RatingModel::MAX_POINTS, $this->ratingModel->validatePenaltiePoints(5000)); //bad
    }

    public function test_SetPenaltiePoints()
    {
        $stub = $this->createMock(CorbleDatabase::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(0.5,$this->ratingModel->setPenaltiesRatioPoints(0.1,0));
        $this->assertEquals(1.5,$this->ratingModel->setPenaltiesRatioPoints(0.1,1));
        $this->assertEquals(0.5,$this->ratingModel->setPenaltiesRatioPoints(1,0));
        $this->assertEquals(2,$this->ratingModel->setPenaltiesRatioPoints(1.1,0));
        $this->assertEquals(2,$this->ratingModel->setPenaltiesRatioPoints(2,0));
        $this->assertEquals(3,$this->ratingModel->setPenaltiesRatioPoints(2,1));
        $this->assertEquals(2,$this->ratingModel->setPenaltiesRatioPoints(2,0));
        $this->assertEquals(58,$this->ratingModel->setPenaltiesRatioPoints(3,55));
        $this->assertEquals(3,$this->ratingModel->setPenaltiesRatioPoints(3.4,0));
        $this->assertEquals(103,$this->ratingModel->setPenaltiesRatioPoints(100,100));
        $this->assertEquals($this->ratingModel->setPenaltiesRatioPoints(-1,0), 0.5);
    }

    public function test_calculatePenaltiesRatio()
    {
        $stub = $this->createMock(CorbleDatabase::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(1.0,$this->ratingModel->calculatePenaltiesRatio(0.7,0.3,0.1,0.9));
        $this->assertEquals(6.5,$this->ratingModel->calculatePenaltiesRatio(2.7,0.3,0.1,0.9));
        $this->assertEquals(6.5,$this->ratingModel->calculatePenaltiesRatio(10,5,1,5));
        $this->assertEquals(6.5,$this->ratingModel->calculatePenaltiesRatio(10,5,1,5));
        $this->assertEquals(1,$this->ratingModel->calculatePenaltiesRatio(10,5,10,5));
    }

    public function test_calculateRatio()
    {
        $stub = $this->createMock(CorbleDatabase::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");

        $result = $this->ratingModel->calculateRatio(50,50,1,1,1,1,"black","red");
        $this->assertEquals(0.5,$result[0]);
        $this->assertEquals(0.5,$result[1]);

        $result = $this->ratingModel->calculateRatio(50,50,1,1,1,1,"yellow","red");
        $this->assertEquals(0.0196078431372549,$result[0]);
        $this->assertEquals(0.9803921568627451,$result[1]);

        $result = $this->ratingModel->calculateRatio(50,50,1,1,1,1,"black","red");
        $this->assertEquals(0.5,$result[0]);
        $this->assertEquals(0.5,$result[1]);
    }
}

?>