@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Permohonan Saya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat Permohonan Saya</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="container">
        <div class="mt-5">
            <table id="permohonanTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Perkiraan Pengembalian</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                        <th>Disetujui Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allPermohonans as $index => $permohonan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $permohonan->nama }} ({{ $permohonan->divisi }})</td>
                            <td>{{ $permohonan->barang->nama_barang }} ({{ $permohonan->jumlah_barang }} unit)</td>
                            <td>{{ $permohonan->tanggal_pinjam }}</td>
                            <td>{{ $permohonan->tanggal_dikembalikan }}</td>
                            <td>{{ $permohonan->tanggal_pengembalian }}</td>
                            <td>{{ $permohonan->status_pengembalian }}</td>
                            <td>{{ $permohonan->disetujui_oleh }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#permohonanTable').DataTable({
                "processing": true,
                "serverSide": false, // ubah ke true jika menggunakan server-side processing
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
@endsection
