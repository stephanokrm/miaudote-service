<?php

use App\Enums\Friendly;
use App\Enums\Playfulness;
use App\Enums\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->date('born_at');
            $table->string('avatar');
            $table->boolean('castrated');
            $table->enum('gender', [Gender::Male->value, Gender::Female->value]);
            $table->enum('playfulness', [Playfulness::One->value, Playfulness::Two->value, Playfulness::Three->value, Playfulness::Four->value, Playfulness::Five->value]);
            $table->enum('family_friendly', [Friendly::One->value, Friendly::Two->value, Friendly::Three->value, Friendly::Four->value, Friendly::Five->value]);
            $table->enum('pet_friendly', [Friendly::One->value, Friendly::Two->value, Friendly::Three->value, Friendly::Four->value, Friendly::Five->value]);
            $table->enum('children_friendly', [Friendly::One->value, Friendly::Two->value, Friendly::Three->value, Friendly::Four->value, Friendly::Five->value]);
            $table->unsignedInteger('ibge_city_id');
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('breed_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
