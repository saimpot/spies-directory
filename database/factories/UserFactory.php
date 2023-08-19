<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Prosperty\Core\Domain\Spy\Enums\Permission;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ];
    }

    public function createAdminUser(): array
    {
        $attributes = [
            User::COLUMN_NAME              => 'Admin',
            User::COLUMN_EMAIL             => sprintf('admin@%s', env('APP_DOMAIN')),
            User::COLUMN_EMAIL_VERIFIED_AT => now(),
            User::COLUMN_PASSWORD          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            User::COLUMN_REMEMBER_TOKEN    => Str::random(10),
        ];

        $user = $this->create($attributes);

        $token = $this->attachTokenToAdminUser($user);

        return ['user' => $user, 'token' => $token];
    }

    public function createApiUser(Permission $permission): array
    {
        $attributes = [
            User::COLUMN_NAME              => "Api {$permission->value} user",
            User::COLUMN_EMAIL             => sprintf('spy-%s-user@%s', $permission->value, env('APP_DOMAIN')),
            User::COLUMN_EMAIL_VERIFIED_AT => now(),
            User::COLUMN_PASSWORD          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            User::COLUMN_REMEMBER_TOKEN    => Str::random(10),
        ];

        $user = $this->create($attributes);

        $token = $this->attachTokenWithPermissionToUser($user, $permission->value);

        return ['user' => $user, 'token' => $token];
    }

    private function attachTokenToAdminUser(User $user): string
    {
        return $user->createToken('spy-token', array_column(Permission::cases(), 'value'))->plainTextToken;
    }

    private function attachTokenWithPermissionToUser(User $user, string $permission): string
    {
        return $user->createToken('spy-token', [$permission])->plainTextToken;
    }
}
