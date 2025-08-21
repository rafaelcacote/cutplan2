<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\User;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Cliente::with(['endereco', 'user']);
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
        return view('clientes.create');
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
        return view('clientes.edit', compact('cliente', 'endereco'));
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
