@extends('master')
@section('title')
    Riwayat Pencatatan | AquaTrack
@endsection
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <style>
        .card-body {
            padding: 20px;
        }

        .form-input {
            background-color: #cccccc;
        }

        button {
            border-radius: 30px;
        }

        @media print {

            .table-bordered th,
            .table-bordered td {
                padding: 10px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card mb-5">
                <div class="card-header pt-2 pb-2">
                    <div class="row header-table">
                        <div class="col">
                            <div class="dropdown">
                                <select class="btn btn-secondary costum-select btn-sm" id="selectOption">
                                    <option value="suhu" selected>Suhu</option>
                                    <option value="ph">pH</option>
                                </select>
                            </div>
                        </div>
                        <div class="col offset-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker" placeholder="Pilih Tanggal"
                                    aria-label="Pilih Tanggal" name="tanggal" aria-describedby="button-addon2">
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                    id="filterButton">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row m-1">

                        <table class="table table-bordered" id="table_suhu">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th id="label">Suhu</th>
                                    <th>Jenis Ikan</th>
                                </tr>
                            </thead>
                            <tbody id="history_suhu">
                                <?php $no = 1; ?>
                                @forelse ($history_suhu as $suhu)
                                    <tr class="suhu-data">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d-m-Y', strtotime($suhu->Tanggal_Monitoring)) }}</td>
                                        <td>{{ date('H:i:s', strtotime($suhu->Tanggal_Monitoring)) }}</td>
                                        <td>{{ $suhu->suhu_Kolam }} &deg; C </td>
                                        <td>{{ $suhu->Jenis_Ikan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Tidak ada data suhu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <table class="table table-bordered" id="table_ph" style="display: none;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>pH</th>
                                    <th>Jenis Ikan</th>
                                </tr>
                            </thead>
                            <tbody id="history_ph">
                                @forelse ($history_ph as $ph)
                                    <tr class="ph-data">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d-m-Y', strtotime($ph->Tanggal_Monitoring)) }}</td>
                                        <td>{{ date('H:i:s', strtotime($ph->Tanggal_Monitoring)) }}</td>
                                        <td>{{ $ph->pH_Kolam }}</td>
                                        <td>{{ $ph->Jenis_Ikan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Tidak ada data pH.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-sm btn-outline-primary" id="printButton">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });

            function updateHistory(data) {
                var suhuData = data.history_suhu;
                var phData = data.history_ph;
                var historysuhu = '';
                var historyph = '';

                if (suhuData.length > 0) {
                    suhuData.forEach(function(item) {
                        historysuhu += '<tr class="suhu-data">';
                        historysuhu += '<td>' + no++ + '</td>';
                        historysuhu += '<td>' + new Date(item.Tanggal_Monitoring).toLocaleDateString(
                            'id-ID') + '</td>';
                        historysuhu += '<td>' + new Date(item.Tanggal_Monitoring).toLocaleTimeString(
                            'id-ID') + '</td>';
                        historysuhu += '<td>' + item.suhu_Kolam + ' &deg; C</td>';
                        historysuhu += '<td>' + item.Jenis_Ikan + '</td>';
                        historysuhu += '</tr>';
                    });
                } else {
                    historysuhu +=
                        '<tr><td colspan="5" class="text-center text-white bg-danger">Tidak ada riwayat pencatatan yang ditemukan.</td></tr>';
                }

                no = 1;
                if (phData.length > 0) {
                    phData.forEach(function(item) {
                        historyph += '<tr class="ph-data">';
                        historyph += '<td>' + no++ + '</td>';
                        historyph += '<td>' + new Date(item.Tanggal_Monitoring).toLocaleDateString(
                            'id-ID') + '</td>';
                        historyph += '<td>' + new Date(item.Tanggal_Monitoring).toLocaleTimeString(
                            'id-ID') + '</td>';
                        historyph += '<td>' + item.pH_Kolam + '</td>';
                        historyph += '<td>' + item.Jenis_Ikan + '</td>';
                        historyph += '</tr>';
                    });
                } else {
                    historyph +=
                        '<tr><td colspan="5" class="text-center text-white bg-danger">Tidak ada riwayat pencatatan yang ditemukan.</td></tr>';
                }

                $('#history_suhu').html(historysuhu);
                $('#history_ph').html(historyph);
                $('#selectOption').trigger('change');
            }

            $('#filterButton').click(function() {
                var selectedDate = $('#datepicker').val();
                var selectedIkanId = sessionStorage.getItem('selectedIkanId');

                if (selectedDate && selectedIkanId) {
                    $.ajax({
                        url: '{{ route('filter_riwayat') }}',
                        type: 'GET',
                        data: {
                            tanggal: selectedDate,
                            jenis_ikan_id: selectedIkanId
                        },
                        success: function(response) {
                            updateHistory(response);
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memfilter data.');
                        }
                    });
                }
            });
            $('#selectOption').change(function() {
                var selectedOption = $(this).val();

                var jenisIkanId = sessionStorage.getItem('selectedIkanId');
                var cetakUrl = '{{ route('cetak_history') }}' + '?jenis=' + selectedOption +
                    '&jenis_ikan_id=' + jenisIkanId;

                if (selectedOption === 'suhu') {
                    $('#table_suhu').show();
                    $('#table_ph').hide();

                    $('#table_suhu').DataTable({
                        searching: false,
                        language: {
                            url: "{{ asset('js/bahasa.json') }}",
                        },
                        columnDefs: [{
                                orderable: false,
                                targets: 4
                            } // Disable sorting on the "Jenis Ikan" column (5th column, index 4)
                        ]
                    });
                    $('#table_ph').DataTable().destroy();


                } else if (selectedOption === 'ph') {
                    $('#table_suhu').hide();
                    $('#table_ph').show();

                    $('#table_ph').DataTable({
                        searching: false,
                        language: {
                            url: "{{ asset('js/bahasa.json') }}",
                        },
                        columnDefs: [{
                                orderable: false,
                                targets: 4
                            } // Disable sorting on the "Jenis Ikan" column (5th column, index 4)
                        ]
                    });
                    $('#table_suhu').DataTable().destroy();
                }
                $('#printButton').attr('onclick', 'window.location.href="' + cetakUrl + '"');
            });

            // Memastikan data suhu ditampilkan saat halaman dimuat
            $('#selectOption').trigger('change');
        });
    </script>
@endsection
