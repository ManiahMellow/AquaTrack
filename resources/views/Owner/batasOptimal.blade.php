@extends('master')
@section('title')
    Profile | AquaTrack
@endsection
@section('style')
    <style>
        input {
            width: 100%;
            outline: 0;
            border: 1px solid #000000;
            background-color: #E7ECEF;
        }

        .ubah {
            width: 80px;
            padding: 2px;
            float: right;
            border-radius: 20px;
        }

        .card-suhu {
            margin: 20px;
            background-color: #E7ECEF;
        }

        .card {
            outline: none;
        }

        .button-ubah {
            float: right;
            background-color: #274C77;
            color: #E7ECEF;
            border-radius: 25px;
            padding-left: 25px;
            padding-right: 25px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card m-1 p-2 mb-">
                <div class="row m-2">
                    <h3>Jenis ikan</h3>
                    <div class="col-10">
                        <div class="dropdown">
                            <select id="pilihanIkan" class="btn dropdown-toggle" style="background-color: #CCCCCC">
                                <option value="">Jenis Ikan</option>
                                @forelse ($dataIkan as $ikan)
                                    <option value="{{ $ikan->id }}">{{ $ikan->Jenis_Ikan }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-1 ml-5">
                        <button class="button-kirim btn btn-secondary btn-small" type="submit">Kirim</button>
                    </div>
                </div>
                <div class="row mt-3" style="margin-left: 5px">
                    <div class="col">
                        <h4>Suhu</h4>
                    </div>
                </div>
                <div class="row" style="margin-top: -15px">
                    <div class="col">
                        <form action="" method="post" id="formSuhu">

                            <div class="card card-suhu outline-none pb-3" style="background-color: #E7ECEF">
                                @csrf
                                @method('PUT')
                                <div class="row m-3">
                                    <div class="col-md-6">
                                        <label for="">Batas minimal</label>
                                        <input type="text" name="minimal_suhu" id="minimal_suhu" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Batas maksimal</label>
                                        <input type="text" name="maksimal_suhu" id="maksimal_suhu" value=""
                                            required>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3 m-3">
                                <div class="col">
                                    <button class="button-ubah" type="submit">Ubah</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="row" style="margin-left: 5px">
                    <div class="col">
                        <h4 class="card-title">pH</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <form action="" method="post" id="formPH">
                            @csrf
                            <div class="card card-suhu mt-3 outline-none pb-3" style="background-color: #E7ECEF">

                                @method('PUT')
                                <div class="row m-3">
                                    <div class="col-md-6">
                                        <label for="">Batas minimal</label>
                                        <input type="text" name="minimal_ph" id="minimal_pH">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Batas maksimal</label>
                                        <input type="text" name="maksimal_ph" id="maksimal_pH">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 m-3">
                                <div class="col">
                                    <button class="button-ubah" type="submit">Ubah</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>

                <div class="row m-5">
                    <div class="col">
                        <div class="card" style="background-color: #E7ECEF">
                            <div class="card-body pb-3">
                                <h4>Panduan :</h4>
                                <p>
                                    Ukuran batas minimal dan batas maksimal pada suhu air dan pH air untuk kolam beberapa
                                    jenis ikan adalah sebagai berikut :
                                </p>
                                @foreach ($dataIkan as $item)
                                    <h6>Ikan {{ $item->Jenis_Ikan }} :</h6>
                                    <p>Rentang suhu air : {{ $item->batas_optimal_suhu->Suhu_Minimal }} -
                                        {{ $item->batas_optimal_suhu->Suhu_Maximal }}&deg; C </p>
                                    <p style="margin-top: -20px;">Rentang pH air : {{ $item->batas_optimal_ph->pH_Minimal }}
                                        - {{ $item->batas_optimal_ph->pH_Maximal }} </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('skyript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (Session::has('nilai_kosong'))
            Swal.fire({
                title: 'GAGAL!',
                text: 'Nilai yang dimasukkan kosong.',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
        @if (Session::has('batas_lebih'))
            Swal.fire({
                title: 'GAGAL!',
                text: 'Nilai minimal yang dimasukkan lebih besar dari batas maksimal.',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000

            });
        @endif
        @if (Session::has('nilai_bukan_angka'))
            Swal.fire({
                title: 'GAGAL!',
                text: 'Nilai yang dimasukkan bukan angka.',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (Session::has('success_ubah_suhu'))
            Swal.fire({
                title: 'GOOD JOB!',
                text: 'Nilai batas optimal suhu berhasil diubah.',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (Session::has('success_ubah_ph'))
            Swal.fire({
                title: 'GOOD JOB!',
                text: 'Nilai batas optimal pH berhasil diubah.',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (Session::has('berhasil_kirim'))
            Swal.fire({
                title: 'GOOD JOB!',
                text: 'Pilihan Ikan berhasil dikirim!.',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.button-kirim').click(function(event) {
                event.preventDefault();

                var ikanId = $('#pilihanIkan').val(); // Mengambil nilai ikanId dari dropdown

                var minimalSuhu = $('#minimal_suhu').val();
                var maksimalSuhu = $('#maksimal_suhu').val();
                var minimalPH = $('#minimal_pH').val();
                var maksimalPH = $('#maksimal_pH').val();

                $.ajax({
                    url: '/arduino/storeData/' +
                        ikanId, // Sesuaikan dengan endpoint storeData yang telah dibuat
                    type: 'POST',
                    data: {
                        ikanId: ikanId,
                        ikanId: ikanId,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        @if (Session::has('berhasil_kirim'))
                            Swal.fire({
                                title: 'GOOD JOB!',
                                text: 'Pilihan Ikan berhasil dikirim!.',
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        @endif
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function updateFormActions(ikanId) {
                var suhuFormAction = "{{ route('update_batas_suhu', ':id') }}";
                suhuFormAction = suhuFormAction.replace(':id', ikanId);
                $('#formSuhu').attr('action', suhuFormAction);

                var pHFormAction = "{{ route('update_batas_ph', ':id') }}";
                pHFormAction = pHFormAction.replace(':id', ikanId);
                $('#formPH').attr('action', pHFormAction);
            }

            function fetchOptimalData(ikanId) {
                $.ajax({
                    url: '/getDataOptimal/' + ikanId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#minimal_suhu').val(response.minimal_suhu);
                        $('#maksimal_suhu').val(response.maksimal_suhu);
                        $('#minimal_pH').val(response.minimal_pH);
                        $('#maksimal_pH').val(response.maksimal_pH);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $('#pilihanIkan').change(function() {
                var ikanId = $(this).val();
                sessionStorage.setItem('selectedIkanId', ikanId);
                updateFormActions(ikanId);
                fetchOptimalData(ikanId);

                // Kirim selectedIkanId ke server untuk disimpan di session
                $.post("{{ route('setSelectedIkanId') }}", {
                    selectedIkanId: ikanId,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    if (data.status === 'success') {
                        console.log("selectedIkanId berhasil disimpan di session.");
                    }
                });
            });

            var selectedIkanId = sessionStorage.getItem('selectedIkanId');
            if (!selectedIkanId) {
                selectedIkanId = 1; // Default select ID 1
                sessionStorage.setItem('selectedIkanId', selectedIkanId);
            }
            $('#pilihanIkan').val(selectedIkanId).trigger('change');
        });
    </script>
@endsection
