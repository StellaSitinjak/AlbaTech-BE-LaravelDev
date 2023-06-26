@extends('layouts.main')
@section('title', 'AlbaTech')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Order</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Order</li>
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
                <div><i class="fas fa-table me-1"></i> Order Data</div>
                <a class="btn btn-primary" href="{{ route('order.create') }}"><i class="fas fa-add"></i> Add New</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Jenis Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $no=1 @endphp
                        @foreach($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->payment }}</td>
                            <td>{{ $datas->total }}</td>
                            <td>{{ $datas->status }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a class="btn btn-submit" href="{{ route('order.show', $datas->id) }}"><i class="fas fa-info-circle"></i></a>
                                    @if ($datas->status == "Pending")
                                    <a class="btn btn-submit" href="{{ route('order.edit', $datas->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn-link" href="{{ route('order.edit', $datas->id) }}" method="delete"
                                        onclick="return confirm('Yakin ingin menghapus order?')"><i
                                            class="fas fa-trash"></i></a>
                                    @endif
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