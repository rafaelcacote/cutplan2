@php
    use Illuminate\Support\Str;
@endphp
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <!-- BEGIN NAVBAR LOGO -->
        <div class="navbar-brand navbar-brand-autodark">
            @if(isset($userTenant) && $userTenant->logo)
                <!-- Logo do Tenant -->
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ Storage::url($userTenant->logo) }}" 
                         alt="{{ $userTenant->nome }}" 
                         class="company-logo-header mb-1"
                         style="height: 64px; width: auto; max-width: 240px; object-fit: contain; border-radius: 4px;">
                    <span class="fw-bold d-none d-md-block" style="font-size: 0.7rem; color: #ffffff; line-height: 1;">
                        {{ $userTenant->nome }}
                    </span>
                </div>
            @else
                <!-- Logo padrão quando não há tenant ou logo -->
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-screwdriver-wrench me-2"></i>
                    <span class="fw-bold" style="font-size: 1.4rem; color: #ffffff;">
                        @if(isset($userTenant) && $userTenant->nome)
                            {{ $userTenant->nome }}
                        @else
                            CutPlan
                        @endif
                    </span>
                </div>
            @endif
        </div>
        <div class="navbar-collapse collapse show" id="sidebar-menu" style="">
            <!-- BEGIN NAVBAR MENU -->
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-house fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Home </span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientes.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-address-book fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Clientes </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fornecedores.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-truck fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Fornecedores </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('materiais.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-box fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Materiais </span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-form" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-people-group"></i>
                        </span>
                        <span class="nav-link-title"> Membros e Equipes </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('membros.index') }}">
                            <i class="fa-solid fa-user me-2"></i> Membros
                        </a>
                        <a class="dropdown-item" href="{{ route('equipes.index') }}">
                            <i class="fa-solid fa-people-group me-2"></i> Equipes
                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orcamentos.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Orçamentos </span>


                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('projetos.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-diagram-project fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Projetos </span>
                    </a>
                </li>

                <!-- Grupo: Gerenciamento de Usuários -->
                <li class="nav-item mt-3 mb-1">
                    <span class="nav-link-title text-uppercase text-muted small fw-bold ps-3">Gerenciamento de
                        Usuários</span>
                </li>
                @can('tenants.listar')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tenants.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fa-solid fa-building fa-lg"></i>
                            </span>
                            <span class="nav-link-title"> Empresas </span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-users fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Usuários </span>
                    </a>
                </li>
                @can('perfis.listar')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fa-solid fa-user-shield fa-lg"></i>
                            </span>
                            <span class="nav-link-title"> Perfis </span>
                        </a>
                    </li>
                @endcan
                @can('permissoes.listar')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fa-solid fa-key fa-lg"></i>
                            </span>
                            <span class="nav-link-title"> Permissões </span>
                        </a>
                    </li>
                @endcan

                <!-- Grupo: Cadastros Básicos -->
                <li class="nav-item mt-3 mb-1">
                    <span class="nav-link-title text-uppercase text-muted small fw-bold ps-3">Cadastros Básicos</span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-form" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </span>
                        <span class="nav-link-title"> Itens e Serviços </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('servicos.index') }}">
                            <i class="fa-solid fa-screwdriver-wrench"></i> Serviços
                        </a>
                        <a class="dropdown-item" href="{{ route('itens-servico.index') }}">
                            <i class="fa-solid fa-list fa-lg"></i> Itens de Serviço
                            <!-- <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span> -->
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cargos.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-user-tag"></i>
                        </span>
                        <span class="nav-link-title"> Cargos </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tipos-materiais.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-cubes-stacked fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Tipos de Materiais </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('unidades.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fa-solid fa-ruler-combined fa-lg"></i>
                        </span>
                        <span class="nav-link-title"> Unidades </span>
                    </a>
                </li>
            </ul>
            <!-- END NAVBAR MENU -->
        </div>
    </div>
</aside>
