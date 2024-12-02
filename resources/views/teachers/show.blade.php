@extends('adminlte::page')

@section('title', 'Scan')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Scan</h1>
@stop

@section('content')
    <!-- Kode Blade Template -->
    <div class="card-container">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="qr-code">
                        {{ QrCode::size(400)->generate($teacher->barcode) }}
                        <div class="name">
                            <h5 class="text-center text-bold m-0 p-0">NIP :{{ $teacher->nip }}</h5>
                            <h6 class="text-center text-bold m-0 p-0">Nama :{{ $teacher->name }}</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@stop
