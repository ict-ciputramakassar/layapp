<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class GroupEvent extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 't_group_event';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'event_registration_id',
        'group_game_id',
        'play',
        'win',
        'lose',
        'draw',
        'point',
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_date' => 'datetime',
            'modified_date' => 'datetime',
        ];
    }

    public function eventRegistration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id', 'id');
    }

    public function groupGame(): BelongsTo
    {
        return $this->belongsTo(GroupGame::class, 'group_game_id', 'id');
    }

}
