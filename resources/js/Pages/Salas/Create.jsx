// resources/js/Pages/Salas/Create.jsx
import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import 'bootstrap/dist/css/bootstrap.min.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Create() {
    const [nome, setNome] = useState('');
    const [capacidade, setCapacidade] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();

        const data = new FormData();
        data.append('nome', nome);
        data.append('capacidade', capacidade);

        // Envia os dados para a rota de store
        axios.post(route('salas.store'), data)
            .then(response => {
                // Aqui você pode fazer algo após o sucesso, como redirecionar ou mostrar uma mensagem
            })
            .catch(error => {
                console.log(error);
            });
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Cadastrar Nova Sala
                </h2>
            }
        >
            <div className="container mt-5">
                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label htmlFor="nome" className="form-label">Nome da Sala</label>
                        <input
                            type="text"
                            className="form-control"
                            id="nome"
                            name="nome"
                            value={nome}
                            onChange={(e) => setNome(e.target.value)}
                            required
                        />
                    </div>

                    <div className="mb-3">
                        <label htmlFor="capacidade" className="form-label">Capacidade</label>
                        <input
                            type="number"
                            className="form-control"
                            id="capacidade"
                            name="capacidade"
                            value={capacidade}
                            onChange={(e) => setCapacidade(e.target.value)}
                            required
                            min="1"
                        />
                    </div>

                    <button type="submit" className="btn btn-success">Salvar</button>
                    <Link href={route('salas.index')} className="btn btn-secondary">Voltar</Link>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
