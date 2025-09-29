<?php

namespace App\Http\Controllers;

use App\Models\ItemServico;
use App\Models\Servico;
use App\Http\Requests\StoreItemServicoRequest;
use App\Http\Requests\UpdateItemServicoRequest;
use Illuminate\Http\Request;

class ItemServicoController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemServico::with('servico');
        if ($request->filled('descricao_item')) {
            $query->where('descricao_item', 'like', '%'.$request->descricao_item.'%');
        }
        if ($request->filled('servico_id')) {
            $query->where('servico_id', $request->servico_id);
        }
        $itens = $query->paginate(10)->appends($request->query());
        $servicos = Servico::orderBy('nome')->get();
        return view('itens_servico.index', compact('itens', 'servicos'));
    }

    public function create()
    {
        $servicos = Servico::orderBy('nome')->get();
        return view('itens_servico.create', compact('servicos'));
    }

    public function store(StoreItemServicoRequest $request)
    {
        try {
            $item = ItemServico::create($request->validated());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item de serviço criado com sucesso!',
                    'item' => $item->load('servico')
                ]);
            }
            
            return redirect()->route('itens-servico.index')->with('success', 'Item de serviço criado com sucesso!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro de validação.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao criar item: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Erro ao criar item: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(ItemServico $itens_servico)
    {
        return view('itens_servico.show', ['item' => $itens_servico]);
    }

    public function edit(ItemServico $itens_servico)
    {
        $servicos = Servico::orderBy('nome')->get();
        return view('itens_servico.edit', ['item' => $itens_servico, 'servicos' => $servicos]);
    }

    public function update(UpdateItemServicoRequest $request, ItemServico $itens_servico)
    {
        try {
            $itens_servico->update($request->validated());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item de serviço atualizado com sucesso!',
                    'item' => $itens_servico->load('servico')
                ]);
            }
            
            return redirect()->route('itens-servico.index')->with('success', 'Item de serviço atualizado com sucesso!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro de validação.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar item: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Erro ao atualizar item: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(ItemServico $itens_servico)
    {
        $itens_servico->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item de serviço excluído com sucesso!'
            ]);
        }
        
        return redirect()->route('itens-servico.index')->with('success', 'Item de serviço excluído com sucesso!');
    }
}
