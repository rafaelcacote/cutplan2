<?php
namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Endereco;
use App\Models\Estado;
use App\Models\Municipio;
use App\Http\Requests\StoreFornecedorRequest;
use App\Http\Requests\UpdateFornecedorRequest;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Fornecedor::with(['endereco.municipio', 'user', 'tenant']);
        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }
        if ($request->filled('search_documento')) {
            $query->where('documento', 'like', '%' . $request->search_documento . '%');
        }
        $fornecedores = $query->paginate($perPage);
        $fornecedores->appends($request->query());
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {
        $estados = Estado::all();
        $municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
            return $group->map(function($m) {
                return ['id' => $m->id, 'nome' => $m->nome];
            });
        });
        return view('fornecedores.create', compact('estados', 'municipios'));
    }

    public function store(StoreFornecedorRequest $request)
    {
        $validated = $request->validated();
        $enderecoData = $validated['endereco'];
        $endereco = Endereco::create($enderecoData);
        
        $fornecedorData = [
            'nome' => $validated['nome'],
            'documento' => $validated['documento'],
            'email' => $validated['email'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
            'endereco_id' => $endereco->id,
            'user_id' => auth()->id(),
            'tenant_id' => auth()->user()->tenant_id,
        ];
        Fornecedor::create($fornecedorData);
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');
    }

    public function show(Fornecedor $fornecedor)
    {
        return view('fornecedores.show', compact('fornecedor'));
    }

    public function edit(Fornecedor $fornecedor)
    {
        $endereco = $fornecedor->endereco;
        $estados = Estado::all();
        $municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
            return $group->map(function($m) {
                return ['id' => $m->id, 'nome' => $m->nome];
            });
        });
        return view('fornecedores.edit', compact('fornecedor', 'endereco', 'estados', 'municipios'));
    }

    public function update(UpdateFornecedorRequest $request, Fornecedor $fornecedor)
    {
        $validated = $request->validated();
        
        $fornecedor->update([
            'nome' => $validated['nome'],
            'documento' => $validated['documento'],
            'email' => $validated['email'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
        ]);
        $fornecedor->endereco->update($validated['endereco']);
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}
