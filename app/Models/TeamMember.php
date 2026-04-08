<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TeamMember extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_team_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'team_id',
        'member_type_id',
        'category_age_id',
        'full_name',
        'dob',
        'phone_number',
        'email',
        'height',
        'weight',
        'position_id',
        'license',
        'valid_date',
        'start_date',
        'end_date',
        'image',
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
    
    protected function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'id', 'team_id');
    }

    protected function memberType(): BelongsTo
    {
        return $this->belongsTo(MemberType::class, 'id', 'member_type_id');
    }

    protected function categoryAge(): BelongsTo
    {
        return $this->belongsTo(CategoryAge::class, 'id', 'category_age_id');
    }

    protected function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'id', 'position_id');
    }
}
