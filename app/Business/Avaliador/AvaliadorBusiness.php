<?php
namespace App\Business\Avaliador;

use App\Models\Avaliador;
use App\Repository\AvaliadorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvaliadorBusiness{

    private AvaliadorRepository $repository;

    public function __construct(){}

    public function createAvaliador(array $data, $user_id){
        $this->repository= new AvaliadorRepository;
        $saved = $this->repository->store($data, $user_id);


        return $saved;
    }

    public function manageAvaliador(){

        $this->repository = new AvaliadorRepository;

        return $this->repository->show();
    }

    public function deleteAvaliador(Request $request){

        $this->repository = new AvaliadorRepository;
        return $this->repository->destroy($request->id);
    }

    public function selectAvaliador(Request $request){

        $this->repository = new AvaliadorRepository;
        $avaliador = $this->repository->getByID($request->id);

        return $avaliador;
    }

    public function updateAvaliador(Request $request){
        $this->repository = new AvaliadorRepository;
        return $this->repository->update($request);
    }

    public function uniqueEmail(String $email){
        return DB::table('avaliadors')->where('email', $email)->exists();
    }
}
