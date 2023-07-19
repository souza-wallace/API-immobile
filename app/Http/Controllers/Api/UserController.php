<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User();

        return response()->json($user->paginate('10'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->has('password')  || !$request->get('password')){
            \Log::error('Insira uma senha para o usuário: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 401);
        }

        $data  = $request->all();

        try {
            $data['password'] = bcrypt($data['password']);
            
            $user = new User;
            $user->create($data);

            return response()->json([
                'data' => [
                    'message' => 'Usuário cadastrado com sucesso!'
                ]
            ], 200);

        } catch (\Throwable $th) {
            \Log::error('Erro ao criar usuário: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'data' => $user
            ], 200);

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data  = $request->all();

        if($request->has('password') && $request->get('password')){
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $user = User::findOrFail($id);
            $user->update($data);

            return response()->json([
                'data' => [
                    'message' => 'usuário atualizado com sucesso!'
                ]
            ], 200);

        } catch (\Throwable $th) {
            \Log::error('Erro ao atualizar usuário: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete($data);

            return response()->json([
                'data' => [
                    'message' => 'usuário deletado com sucesso!'
                ]
            ], 200);

        } catch (\Throwable $th) {
            \Log::error('Erro ao deletar usuário: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
