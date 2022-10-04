<?php

use App\Enums\Friendly;
use App\Enums\Playfulness;
use App\Models\Breed;
use App\Models\User;
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
            $table->enum('gender', [Gender::Male, Gender::Female]);
            $table->enum('playfulness', [Playfulness::One, Playfulness::Two, Playfulness::Three, Playfulness::Four, Playfulness::Five]);
            $table->enum('family_friendly', [Friendly::One, Friendly::Two, Friendly::Three, Friendly::Four, Friendly::Five]);
            $table->enum('pet_friendly', [Friendly::One, Friendly::Two, Friendly::Three, Friendly::Four, Friendly::Five]);
            $table->enum('children_friendly', [Friendly::One, Friendly::Two, Friendly::Three, Friendly::Four, Friendly::Five]);
            $table->string('ibge_city_id');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Breed::class)->constrained();
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
