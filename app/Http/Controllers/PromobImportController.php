<?php

namespace App\Http\Controllers;

use App\Models\ItemProjeto;
use App\Models\MaterialItemProjeto;
use App\Services\PromobImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromobImportController extends Controller
{
    protected $promobImportService;

    public function __construct(PromobImportService $promobImportService)
    {
        $this->promobImportService = $promobImportService;
    }

    /**
     * Exibe a tela de importação para um item específico
     */
    public function show($itemProjetoId)
    {
        $itemProjeto = ItemProjeto::with(['projeto', 'materiaisItem.material'])->findOrFail($itemProjetoId);
        
        return view('promob.import', compact('itemProjeto'));
    }

    /**
     * Preview da importação - mostra os materiais que seriam importados
     */
    public function preview(Request $request, $itemProjetoId)
    {
        $validator = Validator::make($request->all(), [
            'xml_file' => 'required|file|mimes:xml|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo inválido. Envie um arquivo XML válido (máximo 10MB).',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $xmlContent = file_get_contents($request->file('xml_file')->path());
            $preview = $this->promobImportService->previewImportacao($xmlContent);

            return response()->json($preview);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o arquivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Realiza a importação dos materiais
     */
    public function import(Request $request, $itemProjetoId)
    {
        $validator = Validator::make($request->all(), [
            'xml_file' => 'required|file|mimes:xml|max:10240',
            'confirmar_importacao' => 'required|accepted'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $xmlContent = file_get_contents($request->file('xml_file')->path());
            $resultado = $this->promobImportService->importarMateriaisDoXml($xmlContent, $itemProjetoId);

            if ($resultado['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $resultado['message'],
                    'materiais_importados' => $resultado['materiais_importados'],
                    'redirect' => route('projetos.itens.show', $itemProjetoId)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $resultado['message']
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na importação: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lista os materiais importados de um item
     */
    public function materiais($itemProjetoId)
    {
        $itemProjeto = ItemProjeto::findOrFail($itemProjetoId);
        $materiais = MaterialItemProjeto::with('material')
            ->where('item_projeto_id', $itemProjetoId)
            ->get();

        return response()->json([
            'success' => true,
            'materiais' => $materiais
        ]);
    }

    /**
     * Remove um material importado
     */
    public function removeMaterial($itemProjetoId, $materialId)
    {
        $material = MaterialItemProjeto::where('item_projeto_id', $itemProjetoId)
            ->where('id', $materialId)
            ->firstOrFail();

        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Material removido com sucesso.'
        ]);
    }

    /**
     * Vincula um material importado a um material cadastrado
     */
    public function vincularMaterial(Request $request, $itemProjetoId, $materialItemId)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materiais,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Material inválido.',
                'errors' => $validator->errors()
            ], 422);
        }

        $materialItem = MaterialItemProjeto::where('item_projeto_id', $itemProjetoId)
            ->where('id', $materialItemId)
            ->firstOrFail();

        $materialItem->update([
            'material_id' => $request->material_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Material vinculado com sucesso.',
            'material_item' => $materialItem->load('material')
        ]);
    }

    /**
     * Remove a vinculação de um material
     */
    public function desvincularMaterial($itemProjetoId, $materialItemId)
    {
        $materialItem = MaterialItemProjeto::where('item_projeto_id', $itemProjetoId)
            ->where('id', $materialItemId)
            ->firstOrFail();

        $materialItem->update([
            'material_id' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vinculação removida com sucesso.'
        ]);
    }

    /**
     * Limpa todos os materiais importados de um item
     */
    public function limparImportacao($itemProjetoId)
    {
        $itemProjeto = ItemProjeto::findOrFail($itemProjetoId);
        
        $materiaisRemovidos = MaterialItemProjeto::where('item_projeto_id', $itemProjetoId)
            ->where('origem', 'importacao')
            ->count();

        MaterialItemProjeto::where('item_projeto_id', $itemProjetoId)
            ->where('origem', 'importacao')
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "Importação limpa. {$materiaisRemovidos} materiais removidos."
        ]);
    }
}