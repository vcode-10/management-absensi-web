@extends('adminlte::page')

@section('title', 'List Guru')

@section('content_header')
    <h1 class="m-0 text-dark">List Guru</h1>
@stop

@section('content')
    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-2">
        Tambah
    </a>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Barcode</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $key => $teacher)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ QrCode::size(100)->generate($teacher->barcode) }}</td>
                                    <td>{{ $teacher->nip }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>
                                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary btn-xs">
                                            Edit
                                        </a>
                                        <a href="{{ route('teachers.show', $teacher->teacher_id) }}"
                                            class="btn btn-info btn-xs">
                                            show
                                        </a>
                                        <a href="{{ route('teachers.destroy', $teacher) }}"
                                            onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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
