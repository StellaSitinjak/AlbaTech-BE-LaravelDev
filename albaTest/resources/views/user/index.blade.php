@extends('layouts.main')
@section('title', 'AlbaTech')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>

        @if(session('alert'))
        <div class="alert alert-danger">
            <div>{{ session('alert') }}</div>
        </div>
        @endif
        @if(session('alert-success'))
        <div class="alert alert-success">
            <div>{{ session('alert-success') }}</div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div><i class="fas fa-table me-1"></i> User Data</div>
                <a class="btn btn-primary" href="{{ route('user.create') }}"><i class="fas fa-add"></i> Add New</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>E-mail</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>E-mail</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $no=1 @endphp
                        @foreach($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->name }}</td>
                            <td>{{ $datas->email }}</td>
                            <td>{{ $datas->address }}</td>
                            <td>{{ $datas->birthdate }}</td>
                            <td>{{ $datas->gender }}</td>
                            <td>{{ $datas->phoneNum }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a class="btn-link" href="{{ route('user.show', $datas->id) }}"><i
                                            class="fas fa-info-circle"></i></a>
                                    <a class="btn-link" href="#"><i class="fas fa-edit"></i></a>
                                    <a class="btn-link" href="{{ route('user.edit', $datas->id) }}" method="delete"
                                        onclick="return confirm('Yakin ingin menghapus user?')"><i
                                            class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection