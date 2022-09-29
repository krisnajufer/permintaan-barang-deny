<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class UserAuth extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'user_id', 'slug', 'nama', 'role', 'username', 'password', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password'
    ];

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function getAuthPassword()
    {
        return $this->password;
    }

    public static function generateUserId()
    {
        $userId = DB::table('users')->max('user_id');
        $addZero = '';
        $userId = str_replace("U", "", $userId);
        $userId = (int) $userId + 1;
        $incrementUserId = $userId;

        if (strlen($userId) == 1) {
            $addZero = "000";
        } elseif (strlen($userId) == 2) {
            $addZero = "00";
        } elseif (strlen($userId) == 3) {
            $addZero = "0";
        }

        $newUserId = "U" . $addZero . $incrementUserId;
        return $newUserId;
    }
}
