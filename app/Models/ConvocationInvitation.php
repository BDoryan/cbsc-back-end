<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocationInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'convocation_id',
        'accepted',
        'responded_at'
    ];

    /**
     * Accept the invitation
     *
     * @return void
     */
    public function accept() {
        $this->accepted = true;
        $this->responded_at = now();
        $this->save();
    }

    /**
     * Decline the invitation
     *
     * @return void
     */
    public function decline() {
        $this->accepted = false;
        $this->responded_at = now();
        $this->save();
    }

    // Relier à la convocation
    public function convocation() {
        return $this->belongsTo(Convocation::class);
    }

    // Relier à l'utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }
}

