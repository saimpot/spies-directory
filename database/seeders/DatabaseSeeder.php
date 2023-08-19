<?php

namespace Database\Seeders;

use App\Models\Spy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Prompts\TextPrompt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $factory = User::factory()->createAdminUser();
        Spy::factory(400)->create();

        $this->printToken($factory);
    }

    private function printToken(array $factory): void
    {
        $textPrompt = new TextPrompt('');
        echo $textPrompt->black('  ');
        echo $textPrompt->bgGreen($textPrompt->white(' SUCCESS '));
        echo $textPrompt->white(' COPY THE FOLLOWING STRING AND IMPORT TO POSTMAN: ' . $textPrompt->bgMagenta($factory['token']));
        $this->command->newLine(2);
    }
}
