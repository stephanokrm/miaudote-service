<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory, HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'url',
        'avatar',
    ];

    protected $casts = [
        'avatar' => 'boolean',
    ];

    /**
     * @return MorphTo
     */
    public function profile(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return Attribute
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::url($value),
        );
    }
}
