<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Tenant;
use App\Models\Endereco;
use App\Models\Estado;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tenants.listar')->only('index');
        $this->middleware('can:tenants.criar')->only(['create', 'store']);
        $this->middleware('can:tenants.editar')->only(['edit', 'update']);
        $this->middleware('can:tenants.excluir')->only('destroy');
        $this->middleware('can:tenants.ver')->only('show');
    }

    public function index(Request $request)
    {
        $perPage = 10;

        $query = Tenant::with(['endereco']);

        // Filtro por nome
        if ($request->filled('search_name')) {
            $query->where('nome', 'like', '%' . $request->search_name . '%');
        }

        // Filtro por CNPJ
        if ($request->filled('search_cnpj')) {
            $cnpj = preg_replace('/[^0-9]/', '', $request->search_cnpj);
            $query->where('cnpj', 'like', '%' . $cnpj . '%');
        }

        // Filtro por email
        if ($request->filled('search_email')) {
            $query->where('email', 'like', '%' . $request->search_email . '%');
        }

        $tenants = $query->orderBy('nome')->paginate($perPage);

        // Manter os parâmetros de busca na paginação
        $tenants->appends($request->query());

        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        $estados = Estado::all();
        $municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
            return $group->map(function($m) {
                return ['id' => $m->id, 'nome' => $m->nome];
            });
        });
        return view('tenants.create', compact('estados', 'municipios'));
    }

    public function store(StoreTenantRequest $request)
    {
        $validated = $request->validated();

        // Criar endereço primeiro
        $enderecoData = $validated['endereco'];
        $endereco = Endereco::create($enderecoData);

        // Remove caracteres não numéricos do CNPJ
        if (!empty($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        }

        // Remove caracteres não numéricos do telefone
        if (!empty($validated['telefone'])) {
            $validated['telefone'] = preg_replace('/[^0-9]/', '', $validated['telefone']);
        }

        // Upload do logo se fornecido
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('tenants/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Criar tenant com endereço
        $tenantData = [
            'nome' => $validated['nome'],
            'cnpj' => $validated['cnpj'] ?? null,
            'logo' => $validated['logo'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'email' => $validated['email'] ?? null,
            'slug' => $validated['slug'] ?? null,
            'endereco_id' => $endereco->id,
        ];

        $tenant = Tenant::create($tenantData);

        return redirect()->route('tenants.index')->with('success', 'Empresa criada com sucesso!');
    }

    public function show(Tenant $tenant)
    {
        return view('tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $endereco = $tenant->endereco;
        $estados = Estado::all();
        $municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
            return $group->map(function($m) {
                return ['id' => $m->id, 'nome' => $m->nome];
            });
        });
        return view('tenants.edit', compact('tenant', 'endereco', 'estados', 'municipios'));
    }

    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        $validated = $request->validated();

        // Atualizar endereço
        $enderecoData = $validated['endereco'];
        $tenant->endereco->update($enderecoData);

        // Remove caracteres não numéricos do CNPJ
        if (!empty($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        }

        // Remove caracteres não numéricos do telefone
        if (!empty($validated['telefone'])) {
            $validated['telefone'] = preg_replace('/[^0-9]/', '', $validated['telefone']);
        }

        // Upload do novo logo se fornecido
        if ($request->hasFile('logo')) {
            // Remove o logo antigo se existir
            if ($tenant->logo && Storage::disk('public')->exists($tenant->logo)) {
                Storage::disk('public')->delete($tenant->logo);
            }
            
            $logoPath = $request->file('logo')->store('tenants/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Atualizar tenant (sem endereço que já foi atualizado)
        $tenant->update([
            'nome' => $validated['nome'],
            'cnpj' => $validated['cnpj'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'email' => $validated['email'] ?? null,
            'slug' => $validated['slug'] ?? null,
            'logo' => $validated['logo'] ?? $tenant->logo,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Tenant $tenant)
    {
        // Remove o logo se existir
        if ($tenant->logo && Storage::disk('public')->exists($tenant->logo)) {
            Storage::disk('public')->delete($tenant->logo);
        }

        $tenant->delete();
        
        return redirect()->route('tenants.index')->with('success', 'Empresa excluída com sucesso!');
    }
}