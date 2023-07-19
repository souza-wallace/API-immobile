<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
	{
        $category = new Category;

        return response()->json($category->paginate('10'), 200);
	}

	public function store(Request $request)
	{
		$data = $request->all();

		try{
            $category = new Category;
            $category->create($data);

			return response()->json([
				'data' => [
					'msg' => 'Categoria cadastrada com sucesso!'
				]
			], 200);

		} catch (\Throwable $th) {
            \Log::error('Erro ao criar categoria: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
	}

	public function show($id)
	{
		try{
            $category = Category::findOrFail($id);

			return response()->json([
				'data' => $category
			], 200);

		} catch (\Throwable $th) {
            \Log::error('Erro ao mostrar categoria: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
	}

	
	public function update(Request $request, $id)
	{
		$data = $request->all();

		try{

			$category = Category::findOrFail($id);
			$category->update($data);

			return response()->json([
				'data' => [
					'msg' => 'Categoria atualizada com sucesso!'
				]
			], 200);

		} catch (\Throwable $th) {
            \Log::error('Erro ao atualizar categoria: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
	}

	
	public function destroy($id)
	{
		try{

			$category = Category::findOrFail($id);
			$category->delete();

			return response()->json([
				'data' => [
					'msg' => 'Categoria removida com sucesso!'
				]
			], 200);

		} catch (\Throwable $th) {
            \Log::error('Erro ao deletar categoria: ' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
	}
}
