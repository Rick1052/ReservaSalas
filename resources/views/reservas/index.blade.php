@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Reservas</h1>

    <a href="{{ route('reservas.create') }}" class="btn btn-primary mb-3">Fazer Nova Reserva</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Sala</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->usuario }}</td>
                    <td>{{ $reserva->sala->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserva->horario)->format('H:i') }}</td>
                    <td>
                        <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
