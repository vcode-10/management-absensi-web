@extends('adminlte::page')

@section('title', 'Rekap Absen')

@section('content_header')
    <h1 class="m-0 text-dark">Rekap Absen</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-2">
                        <form action="{{ route('total_data') }}" method="get">
                            @csrf

                            <div class="card-header">
                                <h3>Data Rekap</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="filter_bulan" id="filter_bulan" class="form-control">
                                            @for ($i = 1; $i <= 12; $i++)
                                                @php
                                                    $bulan = date('F', mktime(0, 0, 0, $i, 1));
                                                @endphp
                                                <option value="{{ $i }}">{{ $bulan }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Total Sakit</th>
                                    <th>Total Izin</th>
                                    <th>Total Hadir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataGuru as $key => $guru)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $guru['nama'] }}</td>
                                        <td>{{ $guru['nip'] }}</td>
                                        <td>{{ $guru['totalSakit'] }}</td>
                                        <td>{{ $guru['totalIzin'] }}</td>
                                        <td>{{ $guru['totalHadir'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>


@stop

@push('js')
    <script>
        $('#example2').DataTable({
            "responsive": true,
        });
    </script>
@endpush
