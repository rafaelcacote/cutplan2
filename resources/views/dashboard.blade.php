@extends('layouts.app')

@section('content')
    @can('dashboard.acessar')
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body" style="height: 20rem"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body" style="height: 20rem"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body" style="height: 20rem"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body" style="height: 30rem"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    @cannot('dashboard.acessar')
        <div class="alert alert-danger">
            Você não tem permissão para acessar o dashboard.
        </div>
    @endcan
@endsection
