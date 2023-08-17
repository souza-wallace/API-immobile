<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealState;

class RealStateController extends Controller
{
    public function index()
    {

        $realState = new RealState();

        return response()->json($realState->paginate('10'), 200);

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data  = $request->all();
		$images = $request->file('images'); 

        try {
            $realState = new RealState;
            $realState = $realState->create($data);

            if(isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories'], $realState->id);
            }

            if($images){
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'message' => 'Imóvel cadastrado com sucesso!'
                ]
            ], 201);

        } catch (\Throwable $th) {
            \Log::error('Erro ao criar Imóvel: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }

    }

    public function show($id)
    {
        try {
            $realState = RealState::with('photos')->findOrFail($id);

            return response()->json([
                'data' => $realState
            ], 200);

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 401);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data  = $request->all();
		$images = $request->file('images'); 
        
        try {
            
            $realState = RealState::findOrFail($id);
            $realState->update($data);
            
            if(isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }

            if($images){
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'message' => 'Imóvel atualizado com sucesso!'
                ]
            ], 200);

        } catch (\Throwable $th) {
            \Log::error('Erro ao atualizar imóvel: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $realState = RealState::findOrFail($id);
            $realState->delete($data);

            return response()->json([
                'data' => [
                    'message' => 'Imóvel deletado com sucesso!'
                ]
            ], 200);

        } catch (\Throwable $th) {
            \Log::error('Erro ao deletar imóvel: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
