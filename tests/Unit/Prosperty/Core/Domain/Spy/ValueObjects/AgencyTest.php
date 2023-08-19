<?php

declare(strict_types = 1);

namespace Tests\Unit\Prosperty\Core\Domain\Spy\ValueObjects;

use Prosperty\Core\Domain\Spy\ValueObjects\Agency;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    public function testFromStringMethod(): void
    {
        $agencyString = 'MI6';
        $agency = Agency::fromString($agencyString);

        $this->assertInstanceOf(Agency::class, $agency);
    }

    public function testToNativeMethod(): void
    {
        $agencyString = 'MI6';
        $agency = Agency::fromString($agencyString);

        $this->assertSame($agencyString, $agency->toNative());
    }
}
