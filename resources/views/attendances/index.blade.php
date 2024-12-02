@extends('adminlte::page')

@section('title', 'List Absensi')

@section('content_header')
    <h1 class="m-0 text-dark">List Absensi</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-2">
                        <div class="card-header">
                            <h3>Detail Guru yang Sudah Absen</h3>
                        </div>
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>Nama Guru</th>
                                    <th>Tanggal</th>
                                    <th>Waktu Masuk</th>
                                    <th>Waktu Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($namaSudahAbsen as $data)
                                    <tr>
                                        <td>{{ $data['name'] }}</td>
                                        <td>{{ $data['attendances']->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            @if ($data['attendances']->hour_came)
                                                {{ \Carbon\Carbon::parse($data['attendances']->hour_came)->format('H:i:s') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data['attendances']->home_time)
                                                {{ \Carbon\Carbon::parse($data['attendances']->home_time)->format('H:i:s') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data['attendances']->status == 'Hadir')
                                                <span class="badge badge-success">Hadir</span>
                                            @elseif($data['attendances']->status == 'Sakit')
                                                <span class="badge badge-warning">Sakit</span>
                                            @elseif($data['attendances']->status == 'Alpa')
                                                <span class="badge badge-danger">Alpa</span>
                                            @elseif($data['attendances']->status == 'Izin')
                                                <span class="badge badge-info">Izin</span>
                                            @else
                                                <span class="badge badge-primary">Belum ada Keterangan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-2">
                        <div class="card-header">
                            <h3>Nama Guru yang Belum Absen</h3>
                        </div>
                        <table class="table  table-hover table-bordered table-stripped" id="example1">
                            <thead>
                                <tr>
                                    <th>Nama Guru</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($namaBelumAbsen as $guru)
                                    <tr>
                                        <td>{{ $guru['name'] }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info"
                                                onclick="event.preventDefault(); submitForm('{{ $guru['barcode'] }}', 'sick')">Sakit</a>

                                            <a href="#" class="btn btn-primary"
                                                onclick="event.preventDefault(); submitForm('{{ $guru['barcode'] }}', 'approval')">Izin</a>
                                        </td>
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
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        function submitForm(barcode, type) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = type === 'sick' ? '{{ route('attendance.sick') }}' : '{{ route('attendance.approval') }}';

            var csrfField = document.createElement('input');
            csrfField.setAttribute('type', 'hidden');
            csrfField.setAttribute('name', '_token');
            csrfField.setAttribute('value', '{{ csrf_token() }}');

            var barcodeField = document.createElement('input');
            barcodeField.setAttribute('type', 'hidden');
            barcodeField.setAttribute('name', 'barcode');
            barcodeField.setAttribute('value', barcode);

            form.appendChild(csrfField);
            form.appendChild(barcodeField);

            document.body.appendChild(form);
            form.submit();
        }

        $('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    </script>
@endpush
