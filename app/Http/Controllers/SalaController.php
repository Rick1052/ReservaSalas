<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalaController extends Controller
{
    // Mostrar todas as salas
    public function index()
    {
        $salas = Sala::all();
        return Inertia::render('Salas/Index', [
            'salas' => $salas
        ]);
    }

    // Mostrar o formulário para criar uma nova sala
    public function create()
    {
        return Inertia::render('Salas/Create');
    }

    // Salvar uma nova sala no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
        ]);

        Sala::create($request->all());

        return redirect()->back()->with('success', 'Sala criada com sucesso!');

    }

    // Mostrar uma sala específica (opcional, se você for usar)
    public function show($id)
    {
        $sala = Sala::findOrFail($id);
        return Inertia::render('Salas/Show', [
            'sala' => $sala
        ]);
    }

    // Mostrar o formulário para editar uma sala existente
    public function edit($id)
    {
        $sala = Sala::findOrFail($id);

        return Inertia::render('Salas/Edit', [
            'sala' => $sala
        ]);
    }

    // Atualizar uma sala existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
        ]);

        $sala = Sala::findOrFail($id);
        $sala->update($request->all());

        return redirect()->route('salas.index')->with('success', 'Sala atualizada com sucesso!');
    }

    // Deletar uma sala
    public function destroy($id)
    {
        $sala = Sala::findOrFail($id);

        // Verificar se a sala tem reservas antes de excluí-la
        if ($sala->reservas()->count() > 0) {
            return redirect()->route('salas.index')
                ->withErrors(['message' => 'Não é possível excluir esta sala porque ela possui reservas.']);
        }

        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala deletada com sucesso!');
    }

}
