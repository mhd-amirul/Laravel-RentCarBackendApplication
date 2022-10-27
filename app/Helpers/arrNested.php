<?php

namespace App\Helpers;

class arrNested
{
    public static function userInformation($user)
    {
        return [
            "_id" => $user->_id,
            "email" => $user->email,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "no_hp" => $user->no_hp,
            // "created_at" => $user->created_at, cant read on mongodb, why??
            // "updated_at" => $user->updated_at,
            // "email_verified_at" => $user->email_verified_at,
        ];
    }
}
