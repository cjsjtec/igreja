<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Membro;
use App\Celula;

// use App\Http\Requests;
use App\User;
// use Request;
use Response;


class MembroController extends Controller
{
    protected $membro;
    protected $celula;

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Membro $membro)
    {
        $this->membro = $membro;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('view_membros');
    }
    
    public function allMembros()
    {

        $membro = $this->membro->with('celula')->get();
        
        if (!$membro) 
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        }    
        return Response::json($membro, 200);
    }
    public function getMembro($id)
    {
        $membro = $this->membro->getMembro($id);
        
        if (!$membro)
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        }
     
        return Response::json( $membro, 200);
    }
    public function saveMembro(Request $request)
    {
        $input = $request->all();

        $membro = $this->membro->saveMembro($input);

        if (!$membro)
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        } 


        return Response::json($membro->with('celula')->get(), 200);        
    }
    public function updateMembro($id , Request $request)
    {
        $input = $request->all();
        
        $membro = $this->membro->updateMembro($id , $input);
        
        if (!$membro)
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        }
     
        return Response::json($membro->with('celula')->get(), 200);
        
    }
    // public function deleteMembro($id)
    // {
    //     $membro = $this->membro->deleteUser($id);
    //     if (!$membro)
    //     {
    //         return Response::json(['response' => 'Usuário não encontrado'], 400);
    //     }
    //     return Response::json(['response' => 'Usuário removido'], 200);        
    // }
}
