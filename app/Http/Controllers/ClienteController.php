<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\User;
use App\Models\Estado;
use App\Models\Municipio;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Cliente::with(['endereco.municipio', 'user', 'tenant']);
                        
        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }
        if ($request->filled('search_documento')) {
            $query->where('documento', 'like', '%' . $request->search_documento . '%');
        }
        $clientes = $query->paginate($perPage);
        $clientes->appends($request->query());
        return view('clientes.index', compact('clientes'));
    }


    public function create()
    {
        $estados = Estado::all();
        $municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
            return $group->map(function($m) {
                return ['id' => $m->id, 'nome' => $m->nome];
            });
        });
        return view('clientes.create', compact('estados', 'municipios'));
    }

    public function store(StoreClienteRequest $request)
    {
        $validated = $request->validated();
        $enderecoData = $validated['endereco'];
        $endereco = Endereco::create($enderecoData);
        $clienteData = [
            'nome' => $validated['nome'],
            'documento' => $validated['documento'] ?? null,
            'email' => $validated['email'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
            'endereco_id' => $endereco->id,
            'user_id' => auth()->id(),
            'tenant_id' => auth()->user()->tenant_id,
        ];
        Cliente::create($clienteData);
        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $endereco = $cliente->endereco;
        $estados = Estado::all();
        $municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
            return $group->map(function($m) {
                return ['id' => $m->id, 'nome' => $m->nome];
            });
        });
        return view('clientes.edit', compact('cliente', 'endereco', 'estados', 'municipios'));
    }

 

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $validated = $request->validated();
        $enderecoData = $validated['endereco'];
        $cliente->endereco->update($enderecoData);
        $cliente->update([
            'nome' => $validated['nome'],
            'documento' => $validated['documento'] ?? null,
            'email' => $validated['email'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
        ]);
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
