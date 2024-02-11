<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Utils
{
    public static function isSuperAdmin()
    {
        $superAdminIds = explode(',', env('SUPERADMINS'));
        foreach ($superAdminIds as $id) {
            if (Auth::user()->id == $id) {
                return true;
            }
        }
        return false;
    }
}
