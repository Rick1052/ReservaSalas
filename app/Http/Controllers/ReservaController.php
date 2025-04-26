<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Para trabalhar com datas de forma fácil
use App\Models\Reserva;
use App\Models\Sala;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Mostrar todas as reservas
    public function index()
    {
        $reservas = Reserva::with('sala')->get(); // já carrega a sala relacionada
        return view('reservas.index', compact('reservas'));
    }

    // Mostrar o formulário para criar uma nova reserva
    public function create()
    {
        $salas = Sala::all(); // Buscar todas as salas para o select
        return view('reservas.create', compact('salas'));
    }

    // Salvar uma nova reserva
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'usuario' => 'required|string|max:255',
            'sala_id' => 'required|exists:salas,id',
            'data' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(), // Valida que a data não seja anterior à atual
            'horario' => 'required|date_format:H:i', // Horário deve ser no formato correto
        ]);

        // Verificar se já existe uma reserva para a sala no mesmo dia e no mesmo horário com intervalo de 2 horas
        $conflict = Reserva::where('sala_id', $request->sala_id)
            ->whereDate('data', $request->data) // Verifica o mesmo dia
            ->where(function ($query) use ($request) {
                $query->whereBetween('horario', [
                    Carbon::parse($request->data . ' ' . $request->horario)->subHours(2),
                    Carbon::parse($request->data . ' ' . $request->horario)->addHours(2)
                ]);
            })
            ->exists();

        if ($conflict) {
            // Retornar erro em um array, sem redirecionamento
            return back()->withErrors(['horario' => 'A sala já está reservada neste horário ou em um intervalo de 2 horas.'])
                ->withInput();
        }

        // Criar a reserva
        Reserva::create([
            'usuario' => $request->usuario,
            'sala_id' => $request->sala_id,
            'data' => $request->data,
            'horario' => $request->horario,
        ]);

        // Retornar mensagem de sucesso em um array
        return redirect()->route('reservas.index')
            ->with('status', ['message' => 'Reserva realizada com sucesso!']);
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'usuario' => 'required|string|max:255',
            'sala_id' => 'required|exists:salas,id',
            'data' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(), // Valida que a data não seja anterior à atual
            'horario' => 'required|date_format:H:i', // Horário deve ser no formato correto
        ]);

        // Buscar a reserva existente
        $reserva = Reserva::findOrFail($id);

        // Verificar se já existe uma reserva para a sala no mesmo dia e no mesmo horário com intervalo de 2 horas
        $conflict = Reserva::where('sala_id', $request->sala_id)
            ->whereDate('data', $request->data) // Verifica o mesmo dia
            ->where('id', '!=', $id) // Exclui a própria reserva que está sendo atualizada
            ->where(function ($query) use ($request) {
                $query->whereBetween('horario', [
                    Carbon::parse($request->data . ' ' . $request->horario)->subHours(2),
                    Carbon::parse($request->data . ' ' . $request->horario)->addHours(2)
                ]);
            })
            ->exists();

        if ($conflict) {
            // Retornar erro em um array, sem redirecionamento
            return back()->withErrors(['horario' => 'A sala já está reservada neste horário ou em um intervalo de 2 horas.'])
                ->withInput();
        }

        // Atualizar a reserva com os dados validados
        $reserva->update([
            'usuario' => $request->usuario,
            'sala_id' => $request->sala_id,
            'data' => $request->data,
            'horario' => $request->horario,
        ]);

        // Retornar mensagem de sucesso em um array
        return redirect()->route('reservas.index')
            ->with('status', ['message' => 'Reserva atualizada com sucesso!']);
    }



    // Deletar uma reserva
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva deletada com sucesso!');
    }
}
