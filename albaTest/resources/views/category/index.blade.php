@extends('layouts.main')
@section('title', 'AlbaTech')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Category</h1>
        <ol class="breadcrumb -4mb">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Category</li>
        </ol>

        @if (session('name') == 'Admin')
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-10 offset-md-1">
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

                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="col-md-4 control-label"><b>Nama</b></label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center justify-content-between col-md-12">
                                    <input class="submit-button col-md-3 offset-md-5 btn btn-primary" type="submit"
                                        value="Tambah Category">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="Masuk">
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div><i class="fas fa-table me-1"></i> Category Data</div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Total Harga Produk</th>
                            @if (session('name') == 'Admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Total Harga Produk</th>
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
                            <td>{{ $datas->total }}</td>
                            @if (session('name') == 'Admin')
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a class="btn-link" href="{{ route('category.show', $datas->id) }}"><i
                                            class="fas fa-info-circle"></i></a>
                                    <a class="btn-link" href="#"><i class="fas fa-edit"></i></a>
                                    <a class="btn-link" href="{{ route('category.edit', $datas->id) }}" method="delete"
                                        onclick="return confirm('Yakin ingin menghapus category?')"><i
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