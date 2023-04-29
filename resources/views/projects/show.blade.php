@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h1>Title: {{ $project->title }}
                    @if ($project->type)
                        <span class="badge bg-warning rounded-pill">{{ $project->type->name }}</span>
                    @else
                        <span class="badge bg-secondary rounded-pill">Nessuna Categoria</span>
                    @endif
                </h1>

                <p>Slug: {{ $project->slug }}</p>

                <ul class="ps-0 d-flex gap-1">
                    @foreach ($project->technologies as $technology)
                        <span class="badge bg-secondary">{{ $technology->name }}</span>
                    @endforeach
                </ul>

                <p>Content: <br> {{ $project->content }}</p>

            </div>
            <div class="d-flex">
                <a class="btn btn-sm btn-warning" href="{{ route('projects.edit', $project) }}">Edit</a>
                @if ($project->trashed())
                    <form action="{{ route('projects.restore', $project) }}" method="POST">
                        @csrf
                        <input class="btn btn-sn btn-success" type="submit" value="Ripristina">
                    </form>
                @endif
            </div>
        </div>

    </div>

    <div class="container pb-5">
        <h2>Articoli Correlati:</h2>
        @if ($project->type)
            <ul>
                @foreach ($project->type->projects()->where('id', '!=', $project->id)->get() as $related_project)
                    <li>
                        <a href="{{ route('projects.show', $related_project) }}"> {{ $related_project->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            Non ci sonon progetti
        @endif
    </div>
@endsection
