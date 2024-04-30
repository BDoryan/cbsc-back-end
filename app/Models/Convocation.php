<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    use HasFactory;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'content',
        'datetime',
    ];

    public function invitations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConvocationInvitation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Convocation $convocation) {
            $convocation->invitations()->delete();
        });
    }
}
