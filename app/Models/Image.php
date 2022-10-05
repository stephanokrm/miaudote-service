<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
}
