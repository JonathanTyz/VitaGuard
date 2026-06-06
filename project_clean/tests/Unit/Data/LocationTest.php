<?php

namespace Tests\Unit\Data;

use Tests\TestCase;
use App\Data\Location\Province;
use App\Data\Location\City;
use App\Data\Location\District;
use App\Data\Location\Address;
use InvalidArgumentException;

class LocationTest extends TestCase
{

    public function test_create_province(): void
    {
        $prov = new Province(1, "East Java");
        $this->assertEquals($prov->getId(), 1);
        $this->assertEquals($prov->getName(), "East Java");
    }

    public function test_province_id_illegal(): void
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Province ID must be a positive integer.');

        $prov = new Province(-1, "East Java");
    }
    public function test_province_name_illegal(): void
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Province name cannot be empty.');

        $prov = new Province(1, "    ");
    }
    public function test_create_city(): void
    {
        $prov = new Province(1, "East Java");
        $res = new City(1, "Surabaya", $prov);
        $this->assertEquals($res->getId(), 1);
        $this->assertEquals($res->getName(), "Surabaya");
        $this->assertEquals($res->getProvince(), $prov);
    }

    public function test_city_id_illegal(): void
    {
        $prov = new Province(1, "East Java");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('City ID must be a positive integer.');

        $res = new City(-1, "Surabaya", $prov);
    }
    public function test_city_name_illegal(): void
    {
        $prov = new Province(1, "East Java");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('City name cannot be empty.');

        $res = new City(1, "    ", $prov);
    }
}
