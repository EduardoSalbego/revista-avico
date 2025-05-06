<?php

namespace App\Http\Controllers\Utils;
use App\Http\Controllers\Controller;
use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;



class SuperAdmin extends Controller{

    public function generateSuperAdmin(){
        
        try{
            Role::create(['name' => 'editor-chefe']);
            Role::create(['name' => 'editor']);
            Role::create(['name' => 'autor']);
            Role::create(['name' => 'avaliador']);
        }catch(RoleAlreadyExists $e){
        }

        try{
            $userr = Auth::user();
            $user = User::findOrFail($userr->id);
            $user->assignRole('editor', 'editor-chefe', 'avaliador', 'autor');
        }catch(ErrorException $e){
        }
        
        return view('welcome');
    }

    public function generateEditorChefe(){
        try{
            Role::create(['name' => 'editor-chefe']);
            Role::create(['name' => 'editor']);
            Role::create(['name' => 'autor']);
            Role::create(['name' => 'avaliador']);
        }catch(RoleAlreadyExists $e){
        }

        try{
            $userr = Auth::user();
            $user = User::findOrFail($userr->id);
            $user->assignRole('editor-chefe');
        }catch(ErrorException $e){
        }
        
        return view('welcome');
    }


    public function verifyCurrentRole(){
        $user = Auth::user();
        echo "role: " . $user->roles;
    }

    

}

?>