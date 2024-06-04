@extends('master')
@section('title')
    Ubah Password | AquaTrack
@endsection
@section('style')
    <style>
        .card-body {
            padding: 110px;
            margin: auto;
        }

        input {
            display: block;
            outline: none;
            border: 1px solid #000000;
            margin-top: 5px;
            background: #cccccc;
        }

        .form-input {
            background-color: #cccccc;
        }

        button {
            border-radius: 30px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card m-1 p-2">
                <div class="card-body">
                    <div class="card form-input p-2">
                        <div class="row">
                            <div class="col text-center">
                                <h5>Ubah Password</h5>
                            </div>
                            <div class="mt-3 text-center  ">
                                <center>
                                    <form action="{{ route('update_password', auth()->user()->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="">Inputkan password yang valid</label>
                                            <input type="password" name="password" value="{{ $user->backup_password }}"
                                                required>
                                        </div>
                                        <div class="form-group m-3">
                                            <a href="{{ route('profile.index') }}" class="btn btn-danger">Batal</a>
                                            <button type="submit" class="btn btn-costum">Simpan</button>
                                        </div>
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('skyript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (Session::has('password<6'))
            Swal.fire({
                title: 'GAGAL!',
                text: 'Password harus terdiri dari minimal 6 karakter',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
    </script>
@endsection
