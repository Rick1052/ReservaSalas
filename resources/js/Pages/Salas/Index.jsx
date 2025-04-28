// resources/js/Pages/Salas/Index.jsx
import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import 'bootstrap/dist/css/bootstrap.min.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Index() {
    const { salas, flash } = usePage().props;

    const handleDelete = (id, e) => {
        if (!window.confirm('Tem certeza que deseja excluir esta sala?')) {
            e.preventDefault();
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Lista de Salas
                </h2>
            }
        >
            <div className="container mt-5">
                
                <Link href={route('salas.create')} className="btn btn-primary mb-3">
                    Cadastrar Nova Sala
                </Link>

                {flash && flash.success && (
                    <div className="alert alert-success">
                        {flash.success}
                    </div>
                )}

                <table className="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Capacidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {salas.map(sala => (
                            <tr key={sala.id}>
                                <td>{sala.nome}</td>
                                <td>{sala.capacidade}</td>
                                <td>
                                    <Link href={route('salas.edit', sala.id)} className="btn btn-sm btn-warning me-2">
                                        Editar
                                    </Link>

                                    <form
                                        method="POST"
                                        action={route('salas.destroy', sala.id)}
                                        style={{ display: 'inline' }}
                                        onSubmit={(e) => handleDelete(sala.id, e)}
                                    >
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <input type="hidden" name="_token" value={window.Laravel.csrfToken} /> {/* CSRF Token */}
                                        <button type="submit" className="btn btn-sm btn-danger">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AuthenticatedLayout>
    );
}
