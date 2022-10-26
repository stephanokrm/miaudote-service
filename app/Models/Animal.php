<?php

namespace App\Models;

use App\Enums\Friendly;
use App\Enums\Gender;
use App\Enums\Playfulness;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Animal extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $with = [
        'breed',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'born_at',
        'gender',
        'playfulness',
        'family_friendly',
        'pet_friendly',
        'children_friendly',
        'ibge_city_id',
        'castrated',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'born_at' => 'date',
        'ibge_city_id' => 'integer',
        'gender' => Gender::class,
        'playfulness' => Playfulness::class,
        'family_friendly' => Friendly::class,
        'pet_friendly' => Friendly::class,
        'children_friendly' => Friendly::class,
        'castrated' => 'boolean',
    ];

    /**
     * @return Attribute
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::url($value),
        );
    }

    /**
     * @return BelongsToMany
     */
    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'profile');
    }
}
