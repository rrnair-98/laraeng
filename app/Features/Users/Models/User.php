<?php

namespace App\Features\Users\Models;

use App\Features\Sidecar\Users\Constants;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Helpers\Uuid;

class User extends Authenticatable
{
    use Notifiable;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isTeacher() {
        return $this->user_role === Constants::USER_ROLE_TEACHER;
    }

    public function isAdmin() {
        return $this->user_role === Constants::USER_ROLE_ADMIN;
    }

    public function isOps() {
        return $this->user_role === Constants::USER_ROLE_OPS;
    }

    public static function generateSid(){
        $diff = Carbon::now()->diffInSeconds(Carbon::today());
        return "SID-".Carbon::now()->format("Ymd")."$diff".\Illuminate\Support\Str::random(4);
    }
}
