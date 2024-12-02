@extends('adminlte::page')

@section('title', 'Edit Shift')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Shift</h1>
@stop

@section('content')
    <form action="{{ route('shifts.update', $shift) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="shift_name">shift_name</label>
                            <input type="text" class="form-control @error('shift_name') is-invalid @enderror"
                                id="shift_name" name="shift_name" value="{{ $shift->shift_name ?? old('shift_name') }}">
                            @error('shift_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="shift_name">shift_name</label>
                            <input type="text" class="form-control @error('shift_name') is-invalid @enderror"
                                id="shift_name" name="shift_name" value="{{ $shift->shift_name ?? old('shift_name') }}">
                            @error('shift_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        5
                        <div class="form-group">
                            <label for="shift_name">shift_name</label>
                            <input type="text" class="form-control @error('shift_name') is-invalid @enderror"
                                id="shift_name" name="shift_name" value="{{ $shift->shift_name ?? old('shift_name') }}">
                            @error('shift_name')
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
