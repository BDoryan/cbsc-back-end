<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocationInvitationAccepted extends Model
{
    use HasFactory;

    protected $table = 'convocation_invitations_accepted';

    protected $fillable = [
        'convocation_invitation_id'
    ];

    public function invitation() {
        return $this->belongsTo(ConvocationInvitation::class);
    }
}
