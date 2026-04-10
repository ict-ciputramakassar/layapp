<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'm_event';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'start_date',
        'end_date',
        'description',
        'category_level_id',
        'eo_name',
        'eo_logo',
        'created_date',
        'created_by',
        'modified_date',
        'modified_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'created_date' => 'datetime',
            'modified_date' => 'datetime',
        ];
    }

    public function categoryLevel(): BelongsTo
    {
        return $this->belongsTo(CategoryLevel::class, 'category_level_id', 'id');
    }

    public function eventCategoryAges(): HasMany
    {
        return $this->hasMany(EventCategoryAge::class, 'event_id', 'id');
    }

    public function eventCategoryGames(): HasMany
    {
        return $this->hasMany(EventCategoryGame::class, 'event_id', 'id');
    }

    public function eventCategoryTypes(): HasMany
    {
        return $this->hasMany(EventCategoryType::class, 'event_id', 'id');
    }
}
