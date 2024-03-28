<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagingUser extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'user_id'];

    public static $rules = [
        'role' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
