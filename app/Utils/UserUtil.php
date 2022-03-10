<?php

namespace App\Utils;

use App\Models\User;

class UserUtil {
    public static function isAdmin(?User $user=null):bool {
        $user = $user ?? auth()->user();

        return $user->id == 1;
    }

    public static function isCompany(?User $user=null):bool {
        $user = $user ?? auth()->user();

        return $user->is_company == true;
    }

    public static function isAdminOrCompany(?User $user=null):bool {
        return self::isAdmin($user) || self::isCompany($user);
    }
}
