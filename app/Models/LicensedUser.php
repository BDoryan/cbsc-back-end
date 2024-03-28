<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicensedUser extends Model
{
    use HasFactory;

    protected $fillable = ['license_number', 'user_id'];

    public static $rules = [
        'license_number' => 'required|unique:licensed_users'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
