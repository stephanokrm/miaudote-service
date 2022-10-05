<?php

namespace App\Models;

use App\Enums\Species;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
