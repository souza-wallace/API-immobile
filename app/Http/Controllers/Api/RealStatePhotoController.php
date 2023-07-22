<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealStatePhoto;
use Illuminate\Support\Facades\Storage;



class RealStatePhotoController extends Controller
{
    public function setThumb($photoId, $realStateId){

        try {
            $photo = RealStatePhoto::where('real_state_id', $realStateId)->where('is_thumb', true)->first();

            if($photo) $photo->update(['is_thumb' => true]);

            $photo = RealStatePhoto::find($photoId);
            $photo = $photo->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'message' => 'Thumb atualizada com sucesso!'
                ]
            ], 200);
            
        } catch (\Throwable $th) {
            \Log::error('Erro ao atualizar thumb: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function remove($photoId){
        try {

            $photo = RealStatePhoto::find($photoId);

            if($photo){
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }

            return response()->json([
                'data' => [
                    'message' => 'Thumb removida com sucesso!'
                ]
            ], 200);
            
        } catch (\Throwable $th) {
            \Log::error('Erro ao remover thumb: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
