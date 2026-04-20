<?php

namespace App\Models;

use Illuminate\Support\Str;;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GroupSchedule extends Model
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
    protected $table = 't_group_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'team_id_h',
        'team_id_a',
        'score_h',
        'score_a',
        'play_date',
        'created_date',
        'created_by',
        'modified_date',
        'modified_by',
        'event_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
        protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'play_date' => 'datetime',
            'created_date' => 'datetime',
            'modified_date' => 'datetime',
        ];
    }

    public function teamA(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id_a', 'id');
    }

    public function teamH(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id_h', 'id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
