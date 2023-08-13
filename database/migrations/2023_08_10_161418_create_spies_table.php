<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spies', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('agency')->nullable();
            $table->string('country_of_operation')->nullable();
            $table->date('birth_date');
            $table->date('death_date')->nullable();
            $table->timestamps();

            $table->unique(['name', 'surname']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spies');
    }
};
