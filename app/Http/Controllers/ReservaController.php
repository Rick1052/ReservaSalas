<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reserva;
use App\Models\Sala;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservaController extends Controller
{
    // Mostrar todas as reservas
    public function index()
    {
        $reservas = Reserva::with('sala')->get();
        return Inertia::render('Reservas/Index', [
            'reservas' => $reservas
        ]);
    }

    // Mostrar o formulário para criar uma nova reserva
    public function create()
    {
        $salas = Sala::all();
        return Inertia::render('Reservas/Create', [
            'salas' => $salas
        ]);
    }

    // Salvar uma nova reserva
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'sala_id' => 'required|exists:salas,id',
            'data' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            'horario' => 'required|date_format:H:i',
        ]);

        $conflict = Reserva::where('sala_id', $request->sala_id)
            ->whereDate('data', $request->data)
            ->where(function ($query) use ($request) {
                $query->whereBetween('horario', [
                    Carbon::parse($request->data . ' ' . $request->horario)->subHours(2),
                    Carbon::parse($request->data . ' ' . $request->horario)->addHours(2)
                ]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'horario' => 'A sala já está reservada neste horário ou em um intervalo de 2 horas.'
            ])->withInput();
        }

        Reserva::create($request->only(['usuario', 'sala_id', 'data', 'horario']));

        return redirect()->route('reservas.index')->with('success', 'Reserva realizada com sucesso!');
    }

    // Mostrar o formulário para editar uma reserva existente
    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);
        $salas = Sala::all();
        return Inertia::render('Reservas/Edit', [
            'reserva' => $reserva,
            'salas' => $salas
        ]);
    }

    // Atualizar uma reserva existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'sala_id' => 'required|exists:salas,id',
            'data' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            'horario' => 'required|date_format:H:i',
        ]);

        $reserva = Reserva::findOrFail($id);

        $conflict = Reserva::where('sala_id', $request->sala_id)
            ->whereDate('data', $request->data)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('horario', [
                    Carbon::parse($request->data . ' ' . $request->horario)->subHours(2),
                    Carbon::parse($request->data . ' ' . $request->horario)->addHours(2)
                ]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'horario' => 'A sala já está reservada neste horário ou em um intervalo de 2 horas.'
            ])->withInput();
        }

        $reserva->update($request->only(['usuario', 'sala_id', 'data', 'horario']));

        return redirect()->route('reservas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    // Deletar uma reserva    
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva deletada com sucesso!');
    }

}
