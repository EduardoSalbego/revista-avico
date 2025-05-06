<?php

namespace App\Http\Controllers\Auth;

use App\Business\Autor\AutorBusiness;
use App\Business\Avaliador\AvaliadorBusiness;
use App\Business\Editor\EditorBusiness;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefone' => ['required', 'numeric', 'digits:13'],
            'endereco' => ['required', 'string', 'max:255', 'min:10']

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'endereco' => $data['endereco'],
            'telefone' => $data['telefone'],
            'pais_id' => $data['pais_id']
        ]);
        $user->assignRole($data['role']);                 
        $this->createPersonByRole($data, $user->getKey());
        return $user;
    }


    private function createPersonByRole($data, $user_id){
        $role = $data['role'];
        switch($role){
            case 'autor': 
                $autorBusiness = new AutorBusiness();
                $autorBusiness->createAutor($data, $user_id);
            break;
            case 'editor':
                $editorBusiness = new EditorBusiness();
                $editorBusiness->createEditor($data, $user_id);
            break;
            case 'avaliador':
                $avaliadorBusiness = new AvaliadorBusiness();
                $avaliadorBusiness->createAvaliador($data, $user_id);
            break;
        }
    }
}
