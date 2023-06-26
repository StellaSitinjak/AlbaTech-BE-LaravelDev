@extends('layouts.main')
@section('title', 'AlbaTech')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
            <li class="breadcrumb-item active">Category Detail</li>
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
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                {{ $category }}
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Harga Normal</th>
                            <th>Diskon</th>
                            <th>Harga Akhir</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Harga Normal</th>
                            <th>Diskon</th>
                            <th>Harga Akhir</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $no=1 @endphp
                        @foreach($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->name }}</td>
                            <td>{{ $datas->price }}</td>
                            <td>{{ $datas->discount }}</td>
                            <td>{{ ($datas->price - (($datas->discount/100)*$datas->price)) }}</td>
                            <td>
                                @if ($datas->photo != NULL)
                                <img height="100px" src="{{ asset('storage/' . $datas->photo) }}">
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a class="btn btn-submit" href="#"><i class="fas fa-edit"></i></a>
                                    <a class="btn-link" href="{{ route('category.edit', $datas->id) }}" method="delete"
                                        onclick="return confirm('Yakin ingin menghapus category?')"><i
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