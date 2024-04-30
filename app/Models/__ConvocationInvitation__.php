<?php
//
//namespace App\Models;
//
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//
//class __ConvocationInvitation__ extends Model
//{
//    use HasFactory;
//
//    protected $fillable = [
//        'user_id',
//        'convocation_id',
//    ];
//
//    /**
//     * Accept the invitation
//     *
//     * @return void
//     */
//    public function accept() {
//        if($this->accepted()->exists())
//            return;
//
//        $this->declined()->delete();
//        $this->accepted()->create();
//    }
//
//    /**
//     * Decline the invitation
//     *
//     * @return void
//     */
//    public function decline() {
//        if($this->declined()->exists())
//            return;
//
//        $this->accepted()->delete();
//        $this->declined()->create();
//    }
//
//    /**
//     * Return a relation if the invitation has been accepted
//     *
//     * @return \Illuminate\Database\Eloquent\Relations\HasOne
//     */
//    public function accepted(): \Illuminate\Database\Eloquent\Relations\HasOne {
//        return $this->hasOne(ConvocationInvitationAccepted::class, 'convocation_invitation_id');
//    }
//
//    /**
//     * Return a relation if the invitation has been declined
//     *
//     * @return \Illuminate\Database\Eloquent\Relations\HasOne
//     */
//    public function declined(): \Illuminate\Database\Eloquent\Relations\HasOne {
//        return $this->hasOne(ConvocationInvitationDeclined::class, 'convocation_invitation_id');
//    }
//
////    public function status(): string {
////        if($this->accepted()->exists())
////            return 'accepted';
////        if($this->declined()->exists())
////            return 'declined';
////        return 'pending';
////    }
//
//    // Relier à la convocation
//    public function convocation() {
//        return $this->belongsTo(Convocation::class);
//    }
//
//    // Relier à l'utilisateur
//    public function user() {
//        return $this->belongsTo(User::class);
//    }
//
//    protected static function boot() {
//        parent::boot();
//
//        static::deleting(function ($invitation) {
//            $invitation->accepted()->delete();
//            $invitation->declined()->delete();
//        });
//    }
//}
//
