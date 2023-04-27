@extends('layouts.app')

@section('content')
    {{-- <div class=""></div> --}}
    <div class="container py-4">
        <h1>Nuovo Post</h1>
    </div>

    <div class="container py-5">
        <form action="{{ route('projects.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" id="title" aria-describedby="titleHelp">
                {{-- errore title --}}
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- TEXTAREA --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" value="{{ old('content') }}"
                    id="content" style="height:200px"></textarea>
                @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- SELECT --}}
            <div class="mb-3">
                <label for="type-id" class="form-label">type</label>

                <select class="form-select @error('type_id') is-invalid @enderror" id="type-id" name="type_id"
                    aria-label="Default select example">
                    <option value="" selected>Seleziona categoria</option>
                    @foreach ($types as $type)
                        <option @selected(old('type_id') == $type->id) value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>

                {{-- errore type --}}
                @error('type_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
