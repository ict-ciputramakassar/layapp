<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Team extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_team';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'team_type_id',
        'name',
        'address',
        'city_id',
        'province_id',
        'state',
        'found_year',
        'join_date',
        'image',
        'phone_number',
        'email',
        'is_verified',
        'is_active',
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
            'created_date' => 'datetime',
            'modified_date' => 'datetime',
        ];
    }
    
    protected function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'id', 'province_id');
    }

    protected function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'id', 'city_id');
    }

    protected function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'team_id', 'id');
    }

    protected function teamSocials(): HasMany
    {
        return $this->hasMany(TeamSocial::class, 'team_id', 'id');
    }
}
