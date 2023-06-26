@include('layouts.header')

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
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
                                    <form action="{{ route('authenticate') }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" placeholder="name@example.com" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                            <label for="email">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="password">
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember
                                                Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">Forgot Password?</a>
                                            <input class="btn btn-primary" type="submit" value="Masuk">
                                        </div>
                                        <input type="hidden" name="action" value="Masuk">
                                    </form>
                                </div>

                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="/register">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.javascript')
</body>