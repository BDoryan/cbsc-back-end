<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * Return all convocations for the user
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
            )
            ->leftJoin(
                'convocation_invitations_accepted',
                'convocation_invitations.id',
                '=',
                'convocation_invitations_accepted.convocation_invitation_id'
            )
            ->whereNotNull('convocation_invitations_accepted.convocation_invitation_id');
    }

    /**
     * Return all pending invitations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConvocationInvitation::class)
            ->whereDoesntHave('accepted')
            ->whereDoesntHave('declined')
            ->with('convocation')
            ->with('convocation.invitations')
            ->with('convocation.invitations.accepted')
            ->with('convocation.invitations.declined');
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
