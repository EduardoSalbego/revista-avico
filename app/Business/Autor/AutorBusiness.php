<?php
namespace App\Business\Autor;

use App\Models\Autor;
use App\Repository\AutorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutorBusiness{

    private AutorRepository $repository;

    public function __construct(){}

    public function createAutor(array $data, $user_id){
       

        $this->repository = new AutorRepository();
        $this->repository->store($user_id, $data);
    }

    public function manageAutor(){
      
        $this->repository = new AutorRepository;

        return $this->repository->show();
    }

    public function deleteAutor(Request $request){
       
        $this->repository = new AutorRepository();
        return $this->repository->destroy($request->id);
    }

    public function selectAutor(Request $request){
        
        $this->repository = new AutorRepository;
        $autor = $this->repository->getByID($request->id);

        return $autor;
    }

    public function updateAutor(Request $request){
        $this->repository = new AutorRepository;
        return $this->repository->update($request); 
    }

    public function uniqueEmail(String $email){
        return DB::table('users')->where('email', $email)->exists();
    }
}
?>