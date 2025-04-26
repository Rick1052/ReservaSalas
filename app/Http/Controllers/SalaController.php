<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    // Mostrar todas as salas
    public function index()
    {
        $salas = Sala::all();
        return view('salas.index', compact('salas'));
    }

    // Mostrar o formulário para criar uma nova sala
    public function create()
    {
        return view('salas.create');
    }

    // Salvar uma nova sala no banco de dados
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1', // Validando para ser número e não negativo
        ]);

        // Criação da sala com os dados validados
        Sala::create($request->all());

        // Redirecionamento após a criação
        return redirect()->route('salas.index')->with('success', 'Sala criada com sucesso!');
    }


    // Mostrar uma sala específica
    public function show($id)
    {
        $sala = Sala::findOrFail($id);
        return view('salas.show', compact('sala'));
    }

    // Mostrar o formulário para editar uma sala existente
    public function edit($id)
    {
        $sala = Sala::findOrFail($id);
        return view('salas.edit', compact('sala'));
    }

    // Atualizar uma sala existente no banco de dados
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1', // Validando para ser número e não negativo
        ]);

        // Buscar a sala existente
        $sala = Sala::findOrFail($id);

        // Atualizar a sala com os dados validados
        $sala->update($request->all());

        // Redirecionamento após a atualização
        return redirect()->route('salas.index')->with('success', 'Sala atualizada com sucesso!');
    }


    // Deletar uma sala
    public function destroy($id)
    {
        $sala = Sala::findOrFail($id);
        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala deletada com sucesso!');
    }
}
