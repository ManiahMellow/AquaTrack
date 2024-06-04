@extends('master')
@section('title')
    Profile | AquaTrack
@endsection
@section('style')
    <style>
        input {
            width: 100%;
            outline: 0;
            border: 0;
            border-bottom: 2px solid #000000;
        }

        .ubah {
            width: 80px;
            padding: 2px;
            float: right;
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card m-1 p-2">
                <div class="row m-3">
                    <h2 class="card-title">
                        Profil
                    </h2>
                    <h4 class="col-md-2 fw-bold">Email :</h4>
                    <div class="col-md-4">
                        <input type="email" id="floatingInput" value="{{ $user->email_Owner }}">
                    </div>
                    <div class="form-group">
                        <div class="mt-3">
                            <h4 class="col-md-2 fw-bold">Username</h4>
                        </div>
                        <div class="mt-3">
                            <input type="text" class="col-md-4" id="floatingInput" value="{{ $user->username }}">
                        </div>
                        <div class="mt-1">
                            <div class="col-md-4">
                                <a href="{{ route('profile.show', auth()->user()->id) }}"
                                    class="btn btn-secondary ubah">Ubah</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mt-3">
                            <h4 class="col-md-2 fw-bold">Password</h4>
                        </div>
                        <div class="mt-3">
                            <input type="text" class="col-md-4" id="floatingInput" value="{{ $user->backup_password }}">
                        </div>
                        <div class="mt-1">
                            <div class="col-md-4">
                                <a href="{{ route('profile.edit', auth()->user()->id) }}"
                                    class="btn btn-secondary ubah">Ubah</a>
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
        @if (Session::has('success_ubah_username'))
            Swal.fire({
                title: 'GOOD JOB!',
                text: 'Username berhasil diubah!',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
        @if (Session::has('success_ubah_password'))
            Swal.fire({
                title: 'GOOD JOB!',
                text: 'Password berhasil diubah!',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
        
    </script>
@endsection
