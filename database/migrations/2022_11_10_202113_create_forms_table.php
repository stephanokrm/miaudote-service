<?php

use App\Enums\Species;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('species', [Species::Dog->value, Species::Cat->value]);
            $table->foreignIdFor(User::class)->constrained();
            $table->unique([(new User())->getKeyName(), 'species']);
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
