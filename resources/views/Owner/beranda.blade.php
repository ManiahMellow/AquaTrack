@extends('master')
@section('title')
    Beranda | AquaTrack
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h2><b>Halo, {{ auth()->user()->name }}</b></h2>
            <div class="card mt-3 p-3">
                <div class="card-title">
                    <b>Suhu</b>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h1> <img src="{{ asset('img/suhu-icon.png') }}" width="80px" height="80px" alt="">
                            <span id="suhuKolam"></span>&deg; C
                        </h1>
                    </div>
                    <div class="col-md-4">
                        <button id="optimalSuhuBtn"
                            class="btn {{ $optimal_suhu == 'optimal' ? 'btn-costum' : 'btn-danger' }} rounded-pill">
                            {{ $optimal_suhu }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="card mt-3 p-3">
                <div class="card-title">
                    <b>pH</b>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h1> <img src="{{ asset('img/Vector.png') }}" width="80px" height="80px" alt="">
                            <span id="phKolam"></span>
                        </h1>
                    </div>
                    <div class="col-md-4">
                        <button id="optimalPhBtn"
                            class="btn {{ $optimal_pH == 'optimal' ? 'btn-costum' : 'btn-danger' }} rounded-pill">{{ $optimal_pH }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
    @endif
@endsection

@section('skyript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                title: 'Login Success!',
                text: 'Welcome to AquaTrack.',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
    <script>
        // Ambil nilai pilihan jenis ikan dari sessionStorage
        // nilai variabel dibawah terdefenisi ketika terdapat jenis ikan yang dipilih dihalaman beranda
        var selectedIkanId = sessionStorage.getItem('selectedIkanId');

        // Periksa apakah ada nilai pilihan jenis ikan yang disimpan
        // kondisi ini akan di eksekusi ketika terdapat jenis ikan yang dipilih dihalaman beranda
        if (selectedIkanId) {
            // Kirim permintaan AJAX untuk mendapatkan data suhu dan pH kolam berdasarkan jenis ikan yang dipilih
            $.ajax({
                //url ini dapat dilihat di file web.php
                url: '/getDataOptimal/' + selectedIkanId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Tampilkan data suhu dan pH kolam
                    $('#suhuKolam').text(response.now_suhu);
                    $('#phKolam').text(response.now_ph);

                    // Atur tampilan tombol optimal suhu
                    var suhuBtn = $('#optimalSuhuBtn');
                    suhuBtn.text(response.optimal_suhu);
                    suhuBtn.removeClass('btn-danger btn-costum').addClass(response.optimal_suhu == "optimal" ?
                        'btn-costum' : 'btn-danger');

                    // Atur tampilan tombol optimal pH
                    var phBtn = $('#optimalPhBtn');
                    phBtn.text(response.optimal_ph);
                    phBtn.removeClass('btn-danger btn-costum').addClass(response.optimal_ph == "optimal" ?
                        'btn-costum' : 'btn-danger');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Tampilkan pesan error jika terjadi kesalahan
                    // Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data.', 'error');
                }
            });
        }
    </script>
@endsection
