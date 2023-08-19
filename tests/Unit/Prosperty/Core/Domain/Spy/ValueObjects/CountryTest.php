<?php

declare(strict_types = 1);

namespace Tests\Unit\Prosperty\Core\Domain\Spy\ValueObjects;

use Prosperty\Core\Domain\Spy\ValueObjects\Country;
use Tests\TestCase;

class CountryTest extends TestCase
{
    public function testFromStringMethod(): void
    {
        $countryString = 'UK';
        $country = Country::fromString($countryString);

        $this->assertInstanceOf(Country::class, $country);
    }

    public function testToNativeMethod(): void
    {
        $countryString = 'UK';
        $country = Country::fromString($countryString);

        $this->assertSame($countryString, $country->toNative());
    }
}
