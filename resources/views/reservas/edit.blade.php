@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Reserva</h1>

    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário</label>
            <input type="text" class="form-control @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario', $reserva->usuario) }}" required>
            @error('usuario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sala_id" class="form-label">Sala</label>
            <select class="form-select @error('sala_id') is-invalid @enderror" id="sala_id" name="sala_id" required>
                <option value="" selected disabled>Selecione uma sala</option>
                @foreach ($salas as $sala)
                    <option value="{{ $sala->id }}" {{ old('sala_id', $reserva->sala_id) == $sala->id ? 'selected' : '' }}>
                        {{ $sala->nome }} (Capacidade: {{ $sala->capacidade }})
                    </option>
                @endforeach
            </select>
            @error('sala_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data da Reserva</label>
            <input type="date" class="form-control @error('data') is-invalid @enderror" id="data" name="data" value="{{ old('data', $reserva->data) }}" required>
            @error('data')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="horario" class="form-label">Horário da Reserva</label>
            <input type="time" class="form-control @error('horario') is-invalid @enderror" id="horario" name="horario" value="{{ old('horario', $reserva->horario) }}" required>
            @error('horario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
