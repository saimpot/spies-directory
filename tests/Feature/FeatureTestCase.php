<?php

declare(strict_types = 1);

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected UserFactory $userFactory;

    protected function setUp(
    ): void {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }
}
