@extends('admin.layouts.main')


@section('content')
<div class="container content-schedule mt-4">
    <h1 class="title-jadwal text-center">Jadwal {{ $items->name }}</h1>
    <!-- Tambahkan input pencarian di luar tabel -->
    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group fitur-cari">
                        <input type="text" id="search" class="form-control" placeholder="Cari">
                    </div>
                </div>
            </div>
            <a class="btn btn-success px-4 py-2 mr-auto" data-bs-toggle="modal"
                data-bs-target="#tambahJadwalModal">Tambah Jadwal</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped display">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Hari / Tanggal</th>
                            <th class="text-center">Jam Mulai</th>
                            <th class="text-center">Jam Selesai</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                            {{-- <th class="" style="text-align: center;">{{ $playingTime->time }}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fieldSchedules as $fieldSchedule)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $fieldSchedule->date }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $fieldSchedule->time_start }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $fieldSchedule->time_finish }}</td>
                            <td class="text-center" style="vertical-align: middle;">Rp. {{ number_format($fieldSchedule->price, 0, ',', '.') }}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if ($fieldSchedule->is_booked == 0)
                                Available
                                @else
                                Booked
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/admin/daftar-lapangan/edit/{{ $fieldSchedule->id }}"
                                    class="btn btn-warning btn-icon-split btn-sm">
                                    <span class="text">Edit</span>
                                </a>
                                <a id="deleteButton" href="{{ url('/admin/daftar-lapangan/hapus/' . $fieldSchedule->id) }}"
                                    class="btn btn-danger btn-icon-split btn-sm">
                                    <span class="text">Hapus</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>

<script>
    // let table = new DataTable('#myTable');

    $(document).ready(function () {
        // Inisialisasi DataTables dengan konfigurasi pencarian
        var table = $('#myTable').DataTable({
            searching: true, // Hanya aktifkan fitur pencarian
            paging: true, // Nonaktifkan paging (halaman)
            info: true, // Nonaktifkan info jumlah data
            ordering: true, // Nonaktifkan sorting
        });

        // Tambahkan event listener untuk input pencarian
        $('#search').on('keyup', function () {
            table.search(this.value).draw();
        });
    });

</script>

@endsection

@include('admin.fieldSchedule.create')
