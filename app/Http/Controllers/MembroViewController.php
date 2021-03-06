<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

use App\Membro;
use App\Celula;

// use App\Http\Requests;
use App\User;
// use Request;
use Response;


class MembroViewController extends Controller
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
        return view('view_membros')->renderSections()['conteudo'];
    }
    
    public function viewMembro()
    {
        return view('membros_cadastrar')->with('celulas', Celula::all())->renderSections()['conteudo'];
    }

    public function allMembros()
    {
        $membro = $this->membro->with('celula')->get();
        
        if (!$membro) 
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        }    
        return view('membros_consultar')->with('membros', $membro)->renderSections()['conteudo'];
   
    }
    public function getMembro($id)
    {
        $membro = $this->membro->getMembro($id);
        
        if (!$membro)
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        }

        return view('membros_consultar')->with('membros', $membro)->renderSections()['conteudo'];        

        // return $membro;
    }
    public function saveMembro(Request $request)
    {
        $input = $request->all();

        $membro = $this->membro->saveMembro($input);

        if (!$membro)
        {
            //return Response::json(['response' => 'Membro não encontrado'], 400);
        } 

        $membros = $this->membro->with('celula')->get();
        return view('membros_consultar')->with('membros', $membros);       
    }
    public function updateMembro($id , Request $request)
    {
        $input = $request->all();
        // dd($input, $id);
        // return Response::json(['input' => $input, 'id' => $id], 400);
        
        $membro = $this->membro->updateMembro($id , $input);
        
        
        if (!$membro)
        {
            return Response::json(['response' => 'Membro não encontrado'], 400);
        }

        $membros = $this->membro->with('celula')->get();
        return view('membros_consultar')->with('membros', $membros);
        
    }
    public function alterarMembro($id)
    {        
        $membro = $this->membro->getMembro($id);
        
        if (!$membro)
        {
            //return Response::json(['response' => 'Membro não encontrado'], 400);
        }
        return view('membros_cadastrar')->with(['membro' => $membro, 'celulas' => Celula::all()])->renderSections()['conteudo'];
        
        // return view('membros_cadastrar')->with('membro', $membro)->renderSections()['conteudo'];
        
    }
    public function deleteMembro($id)
    {
        $this->membro->deleteMembro($id);
        return Redirect::route('allMembros');
        
        $membros = $this->membro->with('celula')->get();
        
        return view('membros_consultar')->with('membros', $membros)->renderSections()['conteudo'];
    }


}
