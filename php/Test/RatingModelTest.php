<?php

use PHPUnit\Framework\TestCase;
//include_once($_SERVER['DOCUMENT_ROOT'] .'/php/Model/DatabaseConnection.php');

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
        $this->assertEquals(-10, $this->ratingModel->validatePenaltyPoints(-10)); //good
        $this->assertEquals(1,$this->ratingModel->validatePenaltyPoints(1)); //good
        $this->assertEquals(5,$this->ratingModel->validatePenaltyPoints(5)); //good
        $this->assertEquals(10, $this->ratingModel->validatePenaltyPoints(19)); //bad
        $this->assertEquals(10, $this->ratingModel->validatePenaltyPoints(5000)); //bad
    }

    public function test_SetPenaltyPoints(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(0.5,$this->ratingModel->setPenaltiesRatioPoints(0.1,0));
        $this->assertEquals(1.5,$this->ratingModel->setPenaltiesRatioPoints(0.1,1));
        $this->assertEquals(0.5,$this->ratingModel->setPenaltiesRatioPoints(0.3,0));
        $this->assertEquals(2,$this->ratingModel->setPenaltiesRatioPoints(0.4,0));
        $this->assertEquals(2,$this->ratingModel->setPenaltiesRatioPoints(0.6,0));
        $this->assertEquals(3,$this->ratingModel->setPenaltiesRatioPoints(0.6,1));
        $this->assertEquals(3,$this->ratingModel->setPenaltiesRatioPoints(0.7,0));
        $this->assertEquals(0,$this->ratingModel->setPenaltiesRatioPoints(0,0));
    }

    public function test_calculatePenaltiesRatio(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->assertEquals(4.0,$this->ratingModel->calculatePenaltiesRatio(0.7,0.3,0.1,0.9));
        $this->assertEquals(5.0,$this->ratingModel->calculatePenaltiesRatio(2.7,0.3,0.1,0.9));
        $this->assertEquals(3.5,$this->ratingModel->calculatePenaltiesRatio(0.6,0.8,0.3,0));
        $this->assertEquals(0.5,$this->ratingModel->calculatePenaltiesRatio(0.1,0.5,0.1,0.2));
    }

    public function test_calculateRatio(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");

        $result = $this->ratingModel->calculateRatio(50,50,1,1,1,1,1,1,1,"black","red");
        $this->assertEquals(0.5,$result[0]);
        $this->assertEquals(0.5,$result[1]);

        $result = $this->ratingModel->calculateRatio(50,50,1,1,1,1,1,1,1,"yellow","red");
        $this->assertEquals(0.0196078431372549,$result[0]);
        $this->assertEquals(0.9803921568627451,$result[1]);

        $result = $this->ratingModel->calculateRatio(50,50,1,1,1,1,1,1,1,"black","red");
        $this->assertEquals(0.5,$result[0]);
        $this->assertEquals(0.5,$result[1]);
    }

    public function test_setupColorCounter(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");

        $this->assertEquals(1,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"black"));
        $this->assertEquals(2,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"red"));
        $this->assertEquals(3,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"green"));
        $this->assertEquals(4,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"blue"));
        $this->assertEquals(5,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"yellow"));
        $this->assertEquals(6,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"orange"));
        $this->assertEquals(0,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,"yeelow"));
        $this->assertEquals(0,$this->ratingModel->setupColorCounter(1,2,0,0,0,3,4,5,6,""));

    }

    public function test_foreignColorsRate(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->ratingModel->setPrimaryColor("red");
        $this->ratingModel->setSecondaryColor("blue");

        $this->assertEquals(10,$this->ratingModel->foreignColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,0,0,0,RatingModel::MAX_DIFFERENCE_BORDER,0,RatingModel::MAX_DIFFERENCE_BORDER,RatingModel::MAX_DIFFERENCE_BORDER));
        $this->assertEquals(1,$this->ratingModel->foreignColorsRate(1,0,0,0,0,0,0,0,0));
        $this->assertEquals(4,$this->ratingModel->foreignColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,0,0,0,0,0,0,0));
        $this->assertEquals(2,$this->ratingModel->foreignColorsRate(1,0,0,0,0,1,0,0,0));
        $this->assertEquals(5,$this->ratingModel->foreignColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,1,0,0,0,0,0,0));
        $this->assertEquals(0,$this->ratingModel->foreignColorsRate(0,0,0,0,0,0,0,0,0));
        $this->assertEquals(0,$this->ratingModel->foreignColorsRate(0,1,0,0,0,0,1,0,0));
    }
    
    public function test_ratioColorsRate(){
        $stub = $this->createMock(DatabaseLibrary::class);
        $this->ratingModel = new RatingModel($stub,"../../img/Corble.png","Corble");
        $this->ratingModel->setPrimaryColor("red");
        $this->ratingModel->setSecondaryColor("blue");
        $this->ratingModel->setPrimaryOptimalColorRatio(0.5);
        $this->ratingModel->setSecondaryOptimalColorRatio(0.5);

        $this->assertEquals(4,$this->ratingModel->ratioColorsRate(1,23,0,0,0,43,0,0,0));
        $this->assertEquals(4,$this->ratingModel->ratioColorsRate(RatingModel::MAX_DIFFERENCE_BORDER,0,0,0,0,0,0,0,0));
    }
    
}
?>