<?php

namespace App\Models;

use Illuminate\Support\Str;;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';

    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'm_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'email',
        'full_name',
        'phone_number',
        'is_active',
        'created_date',
        'created_by',
        'modified_date',
        'modified_by',
        'user_type_id',
        'password',
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
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'password' => 'hashed',
        ];
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'user_type_id', 'id');
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'user_id', 'id');
    }

    /**
     * Disable remember token (column doesn't exist in table)
     */
    public function getRememberTokenName()
    {
        return null;
    }
}
