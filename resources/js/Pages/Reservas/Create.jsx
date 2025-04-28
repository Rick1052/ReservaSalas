// resources/js/Pages/Reservas/Create.jsx
import React, { useEffect } from 'react';
import { useForm, Link, usePage } from '@inertiajs/react';
import 'bootstrap/dist/css/bootstrap.min.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Create() {
    const { salas, auth } = usePage().props;  // Acessando o usuário logado através de `auth`

    const { data, setData, post, processing, errors } = useForm({
        usuario: auth.user ? auth.user.name : '',  // Definindo o nome do usuário logado
        sala_id: '',
        data: '',
        horario: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('reservas.store'));
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Fazer Nova Reserva
                </h2>
            }
        >
            <div className="container mt-5">

                <form onSubmit={submit}>
                    <div className="mb-3">
                        <label htmlFor="usuario" className="form-label">Usuário</label>
                        <input
                            type="text"
                            id="usuario"
                            className={`form-control ${errors.usuario ? 'is-invalid' : ''}`}
                            value={data.usuario}
                            onChange={e => setData('usuario', e.target.value)}
                            required
                        />
                        {errors.usuario && <div className="invalid-feedback">{errors.usuario}</div>}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="sala_id" className="form-label">Sala</label>
                        <select
                            id="sala_id"
                            className={`form-select ${errors.sala_id ? 'is-invalid' : ''}`}
                            value={data.sala_id}
                            onChange={e => setData('sala_id', e.target.value)}
                            required
                        >
                            <option value="">Selecione uma sala</option>
                            {salas.map(sala => (
                                <option key={sala.id} value={sala.id}>
                                    {sala.nome} (Capacidade: {sala.capacidade})
                                </option>
                            ))}
                        </select>
                        {errors.sala_id && <div className="invalid-feedback">{errors.sala_id}</div>}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="data" className="form-label">Data da Reserva</label>
                        <input
                            type="date"
                            id="data"
                            className={`form-control ${errors.data ? 'is-invalid' : ''}`}
                            value={data.data}
                            onChange={e => setData('data', e.target.value)}
                            required
                        />
                        {errors.data && <div className="invalid-feedback">{errors.data}</div>}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="horario" className="form-label">Horário da Reserva</label>
                        <input
                            type="time"
                            id="horario"
                            className={`form-control ${errors.horario ? 'is-invalid' : ''}`}
                            value={data.horario}
                            onChange={e => setData('horario', e.target.value)}
                            required
                        />
                        {errors.horario && <div className="invalid-feedback">{errors.horario}</div>}
                    </div>

                    <button type="submit" className="btn btn-success" disabled={processing}>
                        {processing ? 'Salvando...' : 'Salvar'}
                    </button>
                    <Link href={route('reservas.index')} className="btn btn-secondary ms-2">
                        Voltar
                    </Link>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
