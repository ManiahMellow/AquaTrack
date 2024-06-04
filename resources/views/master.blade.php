<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
@yield('style')
<style>
    body {
        background-color: #E7ECEF;
        margin-left: 0;
        padding: 0;
    }

    .navbar-expand-lg {
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        box-shadow: 0px 8px 8px #cccccc;
    }

    .my-btn {
        width: 100%;
        margin-left: -20px;
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
        background-color: #cccccc;
        box-shadow: 0px 2px 8px #737171;
        text-align: left;
        padding: 10px;
        padding-left: 40px;
        /* Added padding to shift text right */
    }

    .my-btn:hover {
        background-color: #274C77;
        color: white;
    }

    h2 {
        color: #274C77;
    }

    .btn-costum {
        margin-right: 20px;
        background-color: #00DD09;
        color: #ffffff;
    }

    .btn-costum:hover {
        background-color: #049609;
        color: #ffffff;
    }

    .active {
        background-color: #274C77;
        color: #ffffff;
    }
</style>
</head>

<body>

    {{-- Start Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">AquaTrack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto ">
                    <li class="nav-item pl-2">
                        <a class="nav-link disabled text-dark" aria-current="page" id="jam"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled text-dark" id="tanggal"></a>
                    </li>
                </ul>
                <ul class="navbar-nav sidebarku">
                    <li class="nav-item">
                        <a href="#" class="nav-link disabled text-dark">Monitoring Kolam</a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link  text-dark">{{ auth()->user()->name }} <img
                                src="{{ asset('img/person-circle.svg') }}" width="25px" height="25px"
                                alt=""></a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link text-dark" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><img src="{{ asset('img/box-arrow-right.svg') }}"
                                width="25px" height="25px" alt=""></button>
                        <a href="#" class="nav-link text-dark"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- End Navbar --}}
    <!-- Modal -->
    <form action="/logout" method="POST">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body ">
                        <div class="row mt-3">
                            <div class="col text-center">Apakah anda yakin ingin keluar?</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-12">
                                <center>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-costum">Yakin</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <section class="mt-5 pt-5 " style="margin-top: 2px">
        <div class="container-fluid pt-3">
            <div class="row ">
                <div class="col-md-3 my-sidebar " style="padding-left: 15px;" style="padding-left: 15px;">
                    @if ($active == 'profile')
                        <a href="{{ route('profile.index') }}" style="background-color: #274C77; color: #E7ECEF; ;"
                            class="btn my-btn mb-3">
                            <i class="bi bi-person-fill ml-3"></i> Profil
                        </a>
                    @else
                        <a href="{{ route('profile.index') }}" class="btn my-btn  mb-3">
                            <i class="bi bi-person"></i> Profil
                        </a>
                    @endif

                    {{-- beranda --}}
                    @if ($active == 'beranda')
                        <a href="{{ route('beranda.index') }}" style="background-color: #274C77; color: #E7ECEF"
                            class="btn my-btn  mb-3">
                            <i class="bi bi-house-door-fill ml-3"></i> Beranda
                        </a>
                    @else
                        <a href="{{ route('beranda.index') }}" class="btn my-btn  mb-3">
                            <i class="bi bi-house-door"></i> Beranda
                        </a>
                    @endif

                    {{-- Riwayat Pencatatan --}}
                    @if ($active == 'riwayat_pencatatan')
                        <a href="{{ route('riwayat') }}" style="background-color: #274C77; color: #E7ECEF"
                            class="btn my-btn  mb-3">
                            <i class="bi bi-clock-fill "></i> Riwayat Pencatatan
                        </a>
                    @else
                        <a href="{{ route('riwayat') }}" class="btn my-btn  mb-3">
                            <i class="bi bi-clock"></i> Riwayat Pencatatan
                        </a>
                    @endif

                    {{-- Batas Optimal --}}
                    @if ($active == 'batas_optimal')
                        <a href="{{ route('batas_optimal.index') }}" style="background-color: #274C77; color: #E7ECEF"
                            class="btn my-btn  mb-3">
                            <i class="bi bi-thermometer-half"></i> Batas Optimal
                        </a>
                    @else
                        <a href="{{ route('batas_optimal.index') }}" class="btn my-btn  mb-3">
                            <i class="bi bi-thermometer"></i> Batas Optimal
                        </a>
                    @endif
                </div>
                <div class="col-md-9 ">
                    @yield('content')
                </div>

            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateClock() {
            var now = new Date();
            var jam = now.getHours();
            var menit = now.getMinutes();
            var detik = now.getSeconds();
            var hari = now.toLocaleDateString('id-ID', {
                weekday: 'long'
            });
            var tanggal = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            // Tambahkan nol di depan angka jika kurang dari 10
            jam = padZero(jam);
            menit = padZero(menit);
            detik = padZero(detik);

            // Update elemen HTML dengan nilai jam dan tanggal yang baru
            document.getElementById('jam').innerHTML = jam + ':' + menit + ':' + detik + ' WIB';
            document.getElementById('tanggal').innerHTML = hari + ', ' + tanggal;
        }

        // Fungsi untuk menambahkan nol di depan angka jika kurang dari 10
        function padZero(angka) {
            return angka < 10 ? '0' + angka : angka;
        }

        // Panggil fungsi updateClock setiap detiknya
        setInterval(updateClock, 1000);

        // Panggil fungsi updateClock agar jam langsung tampil saat halaman dimuat
        updateClock();
    </script>
    @yield('skyript')
</body>

</html>
