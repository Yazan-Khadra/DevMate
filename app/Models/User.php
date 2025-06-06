<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'password',
        'profile_image',
        'gender',
        'birth_date',
        'year_id',
        'major_id',
        'bio',
        'cv_url',
        'profile_image_url',
        'social_links',
        'rate',
        'social_links',
        'skills'
    ];

    protected $casts = [
        "social_links" => "array",
        "links" => "array",

    ];



    //each student belong to One year

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }
    //each student belong to One major

    public function major():BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Scope a query to filter users by gender
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $gender
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender)
                    ->where('role', 'student');
    }
    public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'user_id');
}

public function followings()
{
    return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_user_id');
}

}
