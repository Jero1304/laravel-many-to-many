@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center">
            <h1 class="me-auto py-3">Tutti i project</h1>


            <div>
                <a class="btn btn-primary" href="{{ route('projects.create') }}">Nuovo project</a>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <table class="table table-striped table-inverse table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titolo</th>
                    <th>Categoria</th>
                    <th>Data creazione</th>
                    <th>Data Modifica</th>
                    <th>Eliminato</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>
                            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                        </td>
                        <td>{{$project->type ? $project->type->name : '-'}}</td>
                        <td>{{ $project->created_at->format('d/m/Y') }}</td>
                        <td>{{ $project->updated_at->format('d/m/Y') }}</td>
                        <td>{{ $project->trashed() ? 'Eliminato il: ' . $project->deleted_at : '' }}</td>
                        <td>
                            <div class="d-flex">

                                <a class="btn btn-sm btn-secondary" href="{{ route('projects.edit', $project) }}">Edit</a>

                                <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input class="btn btn-sn btn-danger" type="submit" value="Delete">
                                </form>

                                @if ($project->trashed())
                                    <form action="{{ route('projects.restore', $project) }}" method="POST">
                                        @csrf
                                        <input class="btn btn-sn btn-success" type="submit" value="Ripristina">
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="6">Nessun project trovato</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
