<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Prosperty\Core\Domain\Spy\Enums\Permission;

class CreateApiUser extends Command
{
    protected $signature = 'api:create-user {name} {email}';
    protected $description = 'Create a user for the API.';

    public function handle(): int
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        if (blank($name) || blank($email)) {
            $this->error('Name and email are required');

            return self::FAILURE;
        }

        try {
            return DB::transaction(function () use ($name, $email) {
                $user = User::factory()->create([
                    User::COLUMN_NAME  => $name,
                    User::COLUMN_EMAIL => $email,
                ]);

                $this->displayTokenInformation($user);

                if (!$this->confirm('Have you copied the token?')) {
                    throw new InvalidArgumentException('User creation rolled back. You did not confirm the token copy.');
                }

                $this->info("User created: {$user->name} {$user->email}");

                return self::SUCCESS;
            }, self::FAILURE);
        } catch (InvalidArgumentException|QueryException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }

    private function displayTokenInformation(User $user): void
    {
        $token = $user->createToken('spy-token', array_column(Permission::cases(), 'value'));

        $this->info('API Token created. You should copy the following line (token) and use it to authenticate with the API.');
        $this->newLine()->info($token->plainTextToken);
    }
}
