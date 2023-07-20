<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Validator;

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

        Validator::make($data, [
            'phone' => 'required',
            'mobile_phone' => 'required',
        ])->validate();

        try {
            $data['password'] = bcrypt($data['password']);
            
            $user = new User;
            $user = $user->create($data);
           

            $profile = new UserProfile;
            $profile->user_id = $user->id;
            $profile->phone = $data['phone'];
            $profile->mobile_phone = $data['mobile_phone'];
            $profile->save();


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
            $user = User::with('profile')->findOrFail($id);
            $user->profile->social_networks = unserialize($user->profile->social_networks);

            return response()->json([
                'data' => $user
            ], 200);

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 401);
        }
    }

   
    public function update(Request $request, $id)
    {
        $data  = $request->all();

        if($request->has('password') && $request->get('password')){
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        Validator::make($data, [
            'profile.phone' => 'required',
            'profile.mobile_phone' => 'required',
        ])->validate();

        try {
            $profile =$data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = User::findOrFail($id);
            $user->update($data);

            $user->profile()->update($profile);

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
