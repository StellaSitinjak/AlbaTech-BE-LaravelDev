@extends('layouts.main')
@section('title', 'AlbaTech')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Product</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Product</li>
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
                <div><i class="fas fa-table me-1"></i> Product Data</div>
                @if (session('name') == 'Admin')
                <a class="btn btn-primary" href="{{ route('products.create') }}"><i class="fas fa-add"></i> Add New</a>
                @endif
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga Normal</th>
                            <th>Diskon</th>
                            <th>Harga Akhir</th>
                            <th>Gambar</th>
                            @if (session('name') == 'Admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga Normal</th>
                            <th>Diskon</th>
                            <th>Harga Akhir</th>
                            <th>Gambar</th>
                            @if (session('name') == 'Admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $no=1 @endphp
                        @foreach($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->name }}</td>
                            <td>{{ $datas->category }}</td>
                            <td>{{ $datas->price }}</td>
                            <td>{{ $datas->discount }}</td>
                            <td>{{ ($datas->price - (($datas->discount/100)*$datas->price)) }}</td>
                            <td>
                                @if ($datas->photo != NULL)
                                <img height="100px" src="{{ asset('storage/' . $datas->photo) }}">
                                @endif
                            </td>
                            @if (session('name') == 'Admin')
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a class="btn btn-submit" href="{{ route('products.show', $datas->id) }}"><i class="fas fa-info-circle"></i></a>
                                    <a class="btn btn-submit" href="#"><i class="fas fa-edit"></i></a>
                                    <a class="btn-link" href="{{ route('products.edit', $datas->id) }}" method="delete"
                                        onclick="return confirm('Yakin ingin menghapus produk?')"><i
                                            class="fas fa-trash"></i></a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection