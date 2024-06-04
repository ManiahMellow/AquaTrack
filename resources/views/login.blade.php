<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Protest+Guerrilla&family=Quicksand:wght@300..700&family=Wendy+One&display=swap"
        rel="stylesheet">
    <style>
        section {
            background-color: #E7ECEF;
            height: 100vh;
        }

        .card {
            background-color: #D9D9D9;
            border-radius: 0px;
        }

        button {
            width: 100%;
            background-color: #274C77;
            color: white;
            outline: 0;
            border: 0;
            border-radius: 20px;
            padding-top: 5px;
            padding-bottom: 5px
        }

        .wendy-one-regular {
            font-family: "Wendy One", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .ilustrasi {
            padding-left: 25px;
        }
    </style>
</head>

<body>
    <section>
        <div class="container-fluid">
            <div class="row ilustrasi">
                <div class="col-md-3 d-none d-md-block">
                    <img src="{{ asset('img/people.png') }}" alt="">
                </div>
                <div class="col-md-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 mt-3 text-center">
                                <div class="col">
                                    <img src="{{ asset('img/logo.png') }}" alt="">
                                    <h3 class="wendy-one-regular mt-3">AquaTrack</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <form action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username"
                                                class="form-label @error('username') is-invalid @enderror">Username</label>
                                            <input type="text" name="username" class="form-control" id="username"
                                                placeholder="username">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="Password"
                                                class="form-label @error('password') is-invalid @enderror">Password</label>
                                            <input type="password" name="password" class="form-control" id="Passwword">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="col-md-3 offset-md-9 align-self-right">
                                                <a href="{{ route('lupa_password.index') }}"><label for="">Lupa
                                                        Password</label></a>

                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit">submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (session()->has('loginError'))
            <div id="error_login">
        @endif
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (Session::has('loginError'))
            Swal.fire({
                title: 'Login Gagal!',
                text: 'Username atau Password Salah.',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
        @if (Session::has('success_ubah_password'))
            Swal.fire({
                title: 'GOOD JOB!',
                text: 'Password berhasil diubah.',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
        @if (Session::has('success_logout'))
            Swal.fire({
                title: 'Logout Success!',
                text: 'Anda berhasil logout.',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
    </script>
</body>

</html>
