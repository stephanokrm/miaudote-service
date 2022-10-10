<?php

namespace App\Models;

use App\Enums\Species;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Breed extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'species',
    ];

    protected $casts = [
        'species' => Species::class,
    ];

    /**
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::ucfirst($value),
        );
    }
}
