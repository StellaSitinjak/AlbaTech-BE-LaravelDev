@extends('layouts.main')
@section('title', 'AlbaTech')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pendaftaran</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar</li>
        </ol>
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

                    <form action="{{ route('store') }}" method="POST">
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

                                <div class="mb-3">
                                    <label for="address" class="col-md-4 control-label"><b>Alamat</b></label>
                                    <textarea rows="3" id="address" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address') }}" required autofocus></textarea>
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="birthdate" class="col-md-4 control-label"><b>Tanggal Lahir</b></label>
                                    <input id="birthdate" type="date"
                                        class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"
                                        value="{{ old('birthdate') }}" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="gender" class="col-md-4 control-label"><b>Jenis Kelamin</b></label>
                                    <br>
                                    <div class="row">
                                        <div class="col text-center">
                                            <input name="gender" value="P" id="gender" type="radio" checked> Perempuan
                                        </div>
                                        <div class="col text-center">
                                            <input name="gender" value="L" id="gender" type="radio"> Laki-Laki
                                        </div>
                                        <div class="col text-center">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="phoneNum" class="col-md-4 control-label"><b>no. Telepon</b></label>
                                    <input id="phoneNum" type="text"
                                        class="form-control @error('phoneNum') is-invalid @enderror" name="phoneNum"
                                        value="{{ old('phoneNum') }}" required autofocus>
                                    @if ($errors->has('phoneNum'))
                                    <span class="text-danger">{{ $errors->first('phoneNum') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 border-left">
                                <div class="mb-3">
                                    <label for="email" class="col-md-4 control-label"><b>E-Mail Address</b></label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="col-md-4 control-label"><b>Password</b></label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    <p style="color:red">* Panjang minimum password adalah 6</p>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm" class="col-md-6 control-label"><b>Confirm
                                            Password</b></label>
                                    <input id="password-confirm" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required>
                                </div>

                                <div class="form-group" align="left">
                                    <p>To create an account you have to agree our <a class="btn-link" href="#">Terms &
                                            Privacy</a>.</p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between col-md-12">
                                    <input class="submit-button col-md-3 offset-md-5 btn btn-primary" type="submit"
                                        value="Daftar">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="Masuk">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<br><br>
@endsection