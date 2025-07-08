<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,Notifiable,HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name'];
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'device_token',
        'device_type',
        'password',
        'is_email_verified',
        'customer_id',
        'card_number',
        'plan_type',
        'theme',
        'day_count',
        'is_notified',
        'scratched_date',
        'default'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }
    public function role(): BelongsTo
    {
        return $this->BelongsTo(Role::class);
    }

    public function userDetail(): HasOne
    {
        return $this->HasOne(UserDetail::class);
    }

    public function questionResponse(): HasMany
    {
        return $this->HasMany(QuestionResponse::class,'user_id','id');
    }

    public function categoriesOrder(): HasMany
    {
        return $this->HasMany(Order::class,'user_id','id')->where('board_type','customized')->whereNotNull('payment_id');
    }

    public function personalizedOrder(): HasMany
    {
        return $this->HasMany(Order::class,'user_id','id')->where('board_type','personalized')->whereNotNull('payment_id');
    }

}
