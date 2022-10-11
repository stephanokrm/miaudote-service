<?php

use App\Enums\Species;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('breeds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('species', [Species::Dog->value, Species::Cat->value]);
            $table->timestamps();
            $table->unique(['name', 'species']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('breeds');
    }
};
