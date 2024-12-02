@extends('adminlte::page')

@section('title', 'Edit Guru')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Guru</h1>
@stop

@section('content')
    <form action="{{ route('teachers.update', $teacher) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="number" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                name="nip" value="{{ $teacher->nip ?? old('nip') }}">
                            @error('nip')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $teacher->name ?? old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role_id" class="form-label">Role</label>
                            <select id="role_id" name="role_id" class="form-control w-full">
                                @foreach ($roles as $item)
                                    <option value="{{ $item->id }}" @if (old('role_id', $teacher->role_id) == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('teachers.index') }}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @stop
