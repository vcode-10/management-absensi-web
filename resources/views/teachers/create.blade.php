@extends('adminlte::page')

@section('title', 'Tambah Guru')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Guru</h1>
@stop

@section('content')
    <form action="{{ route('teachers.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="number" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                placeholder="Nomor Identitas Pegawai" name="nip" value="{{ old('nip') }}">
                            @error('nip')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="name lengkap" name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <select name="role_id" id="role_id"
                                class="form-control @error('role_id') is-invalid @enderror" id="role_id">
                                @foreach ($roles as $item)
                                    <option value="{{ $item->id }}" @if (old('role_id') == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('shifts.index') }}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @stop
