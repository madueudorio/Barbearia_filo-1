<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminFormRequest;
use App\Http\Requests\AdminFormRequestUpdate;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function criarAdmin(AdminFormRequest $request)
    {
       $admin = Administrador::create([
            'nome' =>  $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'senha' => Hash::make($request->senha)

        ]);
        return response()->json([
            "success" => true,
            "message" => "Admin cadastrado com sucesso",
            "data" =>$admin
        ], 200);
    }

    public function pesquisarPorId($id)
    {
       $admin = Administrador::find($id);
        if ($admin == null) {
            return response()->json([
                'status' => false,
                'message' => "Admin não encontrado"
            ]);
        }
        return response()->json([
            'status' => true,
            'data' =>$admin
        ]);
    }


    public function retornarTodos()
    {
       $admin = Administrador::all();
        return response()->json([
            'status' => true,
            'data' =>$admin
        ]);
    }

    public function pesquisarPorNome(Request $request)
    {
       $admin =  Administrador::where('nome', 'like', '%' . $request->nome . '%')->get();

        if (count($admin) > 0) {

            return response()->json([
                'status' => true,
                'data' =>$admin
            ]);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'Não há resultados para a pesquisa.'
            ]);
        }
    }

    public function excluirAdmin($id)
    {
       $admin = Administrador::find($id);

        if (!isset($admin)) {
            return response()->json([
                'status' => false,
                'message' => "Admin não encontrado"
            ]);
        }
       $admin->delete();
        return response()->json([
            'status' => true,
            'message' => "Admin excluido com sucesso"
        ]);
    }

    public function atualizarAdmin(AdminFormRequestUpdate $request)
    {
       $admin = Administrador::find($request->id);

        if (!isset($admin)) {
            return response()->json([
                'status' => false,
                'message' => "Admin não atualizado"
            ]);
        }

        if (isset($request->nome)) {
           $admin->nome = $request->nome;
        }

        if (isset($request->email)) {
           $admin->email = $request->email;
        }

        if (isset($request->cpf)) {
           $admin->cpf = $request->cpf;
        }

        if (isset($request->senha)) {
           $admin->senha = $request->senha;
        }


       $admin->update();

        return response()->json([
            'status' => true,
            'message' => "Admin atualizados"
        ]);
    }

    public function pesquisarPorCpf(Request $request)
    {
       $admin = Administrador::where('cpf', 'like', '%' . $request->cpf . '%')->get();

        if (count($admin) > 0) {

            return response()->json([
                'status' => true,
                'data' =>$admin
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function pesquisarPorTelefone(Request $request)
    {
       $admin = Administrador::where('celular', 'like', '%' . $request->celular . '%')->get();

        if (count($admin) > 0) {

            return response()->json([
                'status' => true,
                'data' =>$admin
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function pesquisarPorEmail(Request $request)
    {
       $admin = Administrador::where('email', 'like', '%' . $request->email . '%')->get();

        if (count($admin) > 0) {

            return response()->json([
                'status' => true,
                'data' =>$admin
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function esqueciMinhaSenha(Request $request)
    {
       $admin = Administrador::where('email', 'LIKE', $request->email)->first();
        if ($admin) {
            $novaSenha =$admin->cpf;
           $admin->update([
                'senha' => 
                ($novaSenha),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Senha redefinida',
                'nova_senha' =>
                ($novaSenha)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin não encontrado'
            ]);
        }
    }
}
