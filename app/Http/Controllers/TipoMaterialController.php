<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoMaterial;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TipoMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        try {
            // Validação
            $nome = trim($request->nome);
            
            if (empty($nome)) {
                return response()->json([
                    'errors' => ['nome' => ['O nome do tipo é obrigatório.']]
                ], 422);
            }

            if (strlen($nome) > 100) {
                return response()->json([
                    'errors' => ['nome' => ['O nome deve ter no máximo 100 caracteres.']]
                ], 422);
            }

            // Verifica se já existe
            $exists = TipoMaterial::where('nome', $nome)->exists();
            if ($exists) {
                return response()->json([
                    'errors' => ['nome' => ['Já existe um tipo com este nome.']]
                ], 422);
            }

            // Cria o tipo
            $tipo = TipoMaterial::create([
                'nome' => $nome,
            ]);

            return response()->json([
                'id' => $tipo->id, 
                'nome' => $tipo->nome,
                'success' => true,
                'message' => 'Tipo criado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }
}
