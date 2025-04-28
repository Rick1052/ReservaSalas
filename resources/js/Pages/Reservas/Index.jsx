// resources/js/Pages/Reservas/Index.jsx
import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import 'bootstrap/dist/css/bootstrap.min.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Index() {
    const { reservas, flash } = usePage().props;

    const handleDelete = (id, e) => {
        if (!window.confirm('Tem certeza que deseja excluir esta reserva?')) {
            e.preventDefault();
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Lista de Reservas
                </h2>
            }
        >
            <div className="container mt-5">
                <Link href={route('reservas.create')} className="btn btn-primary mb-3">
                    Fazer Nova Reserva
                </Link>

                {flash && flash.success && (
                    <div className="alert alert-success">
                        {flash.success}
                    </div>
                )}

                <table className="table table-striped">
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
                        {reservas.map(reserva => (
                            <tr key={reserva.id}>
                                <td>{reserva.usuario}</td>
                                <td>{reserva.sala ? reserva.sala.nome : 'Sala não encontrada'}</td>
                                <td>{reserva.data}</td>
                                <td>{reserva.horario}</td>
                                <td>
                                    <Link href={route('reservas.edit', reserva.id)} className="btn btn-sm btn-warning me-2">
                                        Editar
                                    </Link>

                                    <form
                                        method="POST"
                                        action={route('reservas.destroy', reserva.id)}
                                        style={{ display: 'inline' }}
                                        onSubmit={(e) => handleDelete(reserva.id, e)}
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
