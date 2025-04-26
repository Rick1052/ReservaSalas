@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Cadastrar Nova Sala</h1>

    <form action="{{ route('salas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Sala</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="capacidade" class="form-label">Capacidade</label>
            <input type="number" class="form-control" id="capacidade" name="capacidade" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('salas.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
