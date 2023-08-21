<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use JsonException;

class UpdatePostmanEnvironment extends Command
{
    public const FILE_PATH = 'postman/postman_environment.json';
    protected $signature = 'postman:env:update {token}';
    protected $description = 'Updates the token in spd_environment.json';

    public function handle(): int
    {
        try {
            if (blank($jsonEnvFile = Storage::get($path = self::FILE_PATH))) {
                $this->error("File not found: {$path}");

                return self::FAILURE;
            }

            $decodedfile = json_decode($jsonEnvFile, true, 512, JSON_THROW_ON_ERROR);
            Arr::set($decodedfile, 'values.1.value', $newToken = $this->argument('token'));

            Storage::put($path, json_encode($decodedfile, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            $this->info("Token updated successfully to \"{$newToken}\"!");
        } catch (JsonException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
