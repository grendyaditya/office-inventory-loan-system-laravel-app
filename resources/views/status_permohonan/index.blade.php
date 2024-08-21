@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Permohonan Barang yang Perlu Disetujui</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Status Permohonan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Error Messages -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Table -->
            <div class="table-responsive">
                <table id="permohonanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permohonanPinjaman as $permohonan)
                            @php
                                $userId = auth()->id();
                                $userHasApproved = in_array($userId, $permohonan->izin_user_ids ?? []);
                                $userHasRejected = in_array($userId, $permohonan->tolak_user_ids ?? []);
                            @endphp
                            @if(!$userHasApproved && !$userHasRejected)
                                <tr>
                                    <td>{{ $permohonan->permohonanPinjaman->nama }} ({{ $permohonan->permohonanPinjaman->divisi }})</td>
                                    <td>{{ $permohonan->permohonanPinjaman->barang->nama_barang }}</td>
                                    <td>{{ $permohonan->permohonanPinjaman->jumlah_barang }}</td>
                                    <td>{{ $permohonan->permohonanPinjaman->tanggal_pinjam }}</td>
                                    <td>{{ $permohonan->permohonanPinjaman->tanggal_dikembalikan }}</td>
                                    <td>{{ $permohonan->permohonanPinjaman->alasan }}</td>
                                    <td>
                                        <form action="{{ route('status_permohonan.izin', $permohonan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                        </form>
                                        <form action="{{ route('status_permohonan.tolak', $permohonan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
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
