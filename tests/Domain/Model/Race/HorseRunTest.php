<?php

namespace Tests\Domain\Model\Race;

use PHPUnit\Framework\TestCase;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Horse\HorseRepository;
use App\Domain\Model\Horse\Stats\HorseStats;
use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Race\Stats\HorseRunStats;
use App\Domain\Model\Horse\Stats\Distance;

//use App\Tests\PHPUnitUtil;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2019-09-03 at 04:47:12.
 */
class HorseRunTest extends TestCase
{
    /** @var HorseRun */
    protected $object;

    protected function setUp(): void
    {
        $horse = new Horse(
            HorseRepository::obj(),
            HorseStats::obj(2.0, 2.0, 2.0)
        );

        $this->object = new HorseRun($horse, HorseRunStats::obj());
    }

    public function testCreate()
    {
        $data                   = new \stdClass();
        $data->horse_id         = 'abc';
        $data->speed            = 2;
        $data->strength         = 2;
        $data->endurance        = 2;
        $data->distance_covered = 0;
        $data->time             = 0;
        $data->horse_position   = 0;

        $horseRun = HorseRun::obj($data);

        $this->assertEquals(0, $horseRun->stats()->distanceCovered()->value());
    }

//    public function testSlownessFactor()
//    {
////        $value = PHPUnitUtil::callMethod($this->object, 'slownessFactor');
//
////        $this->assertEquals(0.8, $value);
//    }
//
//    public function testSlowSpeed()
//    {
////        $value = PHPUnitUtil::callMethod($this->object, 'slowSpeed');
//
////        $this->assertEquals(6.2, $value->distance()->value());
//    }

    public function testRunForTenSeconds()
    {
        $this->setUp();
        $this->object->run(10, new Distance(1500));

        $this->assertEquals(10, $this->object->stats()->time()->value());
        $this->assertEquals(70, $this->object->stats()->distanceCovered()->value());
    }

    public function testRunForSeconds()
    {
        $this->setUp();
        $this->object->run(40, new Distance(1500));

        $distanceCovered = $this->object->stats()->distanceCovered()->value();
        $distanceCovered = number_format($distanceCovered, 2);

        $this->assertEquals(40, $this->object->stats()->time()->value());
        $this->assertEquals(270.86, $distanceCovered);
    }

    public function testRunForFourMinutes()
    {
        $this->setUp();
        $this->object->run(240, new Distance(1500));

        $resultSeconds = $this->object->stats()->time()->value();
        $resultSeconds = number_format($resultSeconds, 2);

        $this->assertEquals(238.28, $resultSeconds);
        $this->assertEquals(1500, $this->object->stats()->distanceCovered()->value());
    }

    public function testIsStillGoing()
    {
        $this->assertTrue($this->object->isStillGoing(new Distance(1500)));
    }

    public function testIsStillGoingZero()
    {
        $this->assertFalse($this->object->isStillGoing(new Distance(0)));
    }
//    public function testFullSpeedDistance()
//    {
//        $this->assertEquals(200, $this->object->fullSpeed()->distance()->value());
//    }
}
