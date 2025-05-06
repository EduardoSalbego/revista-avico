<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{

    public function queryTitle(String $title){
        $users = User::where('name', 'LIKE', '%'.$title.'%')->get();
        return $users;
    }

}
