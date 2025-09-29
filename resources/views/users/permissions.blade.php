@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Permissões do Usuário</h1>
    <form action="{{ route('users.permissions.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="roles" class="form-label">Perfis</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if($user->roles->contains($role)) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
