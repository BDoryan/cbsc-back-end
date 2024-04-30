<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use NotificationChannels\WebPush\PushSubscription;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPushSubscriptions;

    const ROLE_LICENSED = 'licensed';
    const ROLE_MANAGING = 'managing';

    const SEX_WOMEN = 'W';
    const SEX_MALE = "M";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'birthdate',
        'sex',
        'password',
        'picture'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email|unique:users',
        'phone' => 'required|min:10|max:10|unique:users',
        'birthdate' => 'required|date',
        'sex' => 'required|in:W,M',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
    ];

    /**
     * Return all convocations for the user accepted and not outdated
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function convocations(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this
            ->hasManyThrough(
                Convocation::class,
                ConvocationInvitation::class,
                'user_id',
                'id',
                'id',
                'convocation_id'
            )->whereHas('invitations', function ($query) {
                $query->where('accepted', true);
            })->where('datetime', '>=', now());
    }

    /**
     * Return all pending invitations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConvocationInvitation::class)
            ->where('accepted', null)
            ->with('convocation')
            ->whereHas('convocation', function ($query) {
                $query->where('datetime', '>=', now());
            })
            ->with('convocation.invitations');
    }

    public function licensed(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LicensedUser::class);
    }

    public function managing(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ManagingUser::class);
    }
}
