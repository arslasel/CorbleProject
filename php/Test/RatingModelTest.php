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

    public function test_PointValidation(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(-10, $this->ratingModel->validatePenaltiePoints(-10)); //good
        $this->assertEquals(1,$this->ratingModel->validatePenaltiePoints(1)); //good
        $this->assertEquals(5,$this->ratingModel->validatePenaltiePoints(5)); //good
        $this->assertEquals(RatingModel::MAX_POINTS, $this->ratingModel->validatePenaltiePoints(19)); //bad
        $this->assertEquals(RatingModel::MAX_POINTS, $this->ratingModel->validatePenaltiePoints(5000)); //bad
    }

    public function test_SetPenaltiePoints(){
        $stub = $this->createMock(DatabaseLibrary::class);
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

    public function test_calculatePenaltiesRatio(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(1.0,$this->ratingModel->calculatePenaltiesRatio(0.7,0.3,0.1,0.9));
        $this->assertEquals(6.5,$this->ratingModel->calculatePenaltiesRatio(2.7,0.3,0.1,0.9));
        $this->assertEquals(6.5,$this->ratingModel->calculatePenaltiesRatio(10,5,1,5));
        $this->assertEquals(6.5,$this->ratingModel->calculatePenaltiesRatio(10,5,1,5));
        $this->assertEquals(1,$this->ratingModel->calculatePenaltiesRatio(10,5,10,5));
    }

    public function test_calculateRatio(){
        $stub = $this->createMock(DatabaseLibrary::class);
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

    public function test_setupColorCounter(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");

        $this->assertEquals(1,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"black"));
        $this->assertEquals(2,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"red"));
        $this->assertEquals(3,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"green"));
        $this->assertEquals(4,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"blue"));
        $this->assertEquals(5,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"yellow"));
        $this->assertEquals(6,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"orange"));
        $this->assertEquals(0,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,"yeelow"));
        $this->assertEquals(0,$this->ratingModel->setupColorCounter(1,2,3,4,5,6,""));

    }

    public function test_foreignColorsRate(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->ratingModel->setPrimaryColor("red");
        $this->ratingModel->setSecondaryColor("blue");

        $this->assertEquals(10,$this->ratingModel->foreignColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,RatingModel::MAX_DIFFERENCE_BORDER,0,RatingModel::MAX_DIFFERENCE_BORDER,RatingModel::MAX_DIFFERENCE_BORDER));
        $this->assertEquals(1,$this->ratingModel->foreignColorsRate(1,0,0,0,0,0));
        $this->assertEquals(4,$this->ratingModel->foreignColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,0,0,0,0));
        $this->assertEquals(2,$this->ratingModel->foreignColorsRate(1,0,1,0,0,0));
        $this->assertEquals(5,$this->ratingModel->foreignColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,1,0,0,0));
        $this->assertEquals(0,$this->ratingModel->foreignColorsRate(0,0,0,0,0,0));
        $this->assertEquals(0,$this->ratingModel->foreignColorsRate(0,1,0,1,0,0));
    }
    
    public function test_ratioColorsRate(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->ratingModel->setPrimaryColor("red");
        $this->ratingModel->setSecondaryColor("blue");
        $this->ratingModel->setPrimaryOptimalColorRatio(0.5);
        $this->ratingModel->setSecondaryOptimalColorRatio(0.5);

        $this->assertEquals(0.5,$this->ratingModel->ratioColorsRate(1,23,43,0,0,0));
        $this->assertEquals(4,$this->ratingModel->ratioColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,0,0,0,0));
    }
    
}

?>