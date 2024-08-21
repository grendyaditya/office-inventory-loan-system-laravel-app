@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengembalian Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pengembalian Barang</li>
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Success Message -->
            @if (session('success'))
                @include('partials.alert', ['type' => 'success', 'message' => session('success')])
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                @include('partials.alert', ['type' => 'danger', 'message' => $errors->all()])
            @endif

            <!-- No Data Message -->
            @if($permohonanPinjaman->isEmpty())
                @include('partials.alert', ['type' => 'info', 'message' => 'Tidak ada barang yang dapat dikembalikan.'])
            @else
                <div class="table-responsive">
                    <table id="pengembalianTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Dikembalikan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permohonanPinjaman as $permohonan)
                                <tr>
                                    <td>{{ $permohonan->nama }}</td>
                                    <td>{{ $permohonan->divisi }}</td>
                                    <td>{{ $permohonan->barang->nama_barang }}</td>
                                    <td>{{ $permohonan->jumlah_barang }}</td>
                                    <td>{{ $permohonan->tanggal_pinjam }}</td>
                                    <td>{{ $permohonan->tanggal_dikembalikan }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('pengembalian.store') }}" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="permohonan_pinjaman_id" value="{{ $permohonan->id }}">
                                            <button type="submit" class="btn btn-primary">
                                                Kembalikan Barang
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#pengembalianTable').DataTable({
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
        
        // Mendapatkan nilai dari header X-Current-Path
      

    </script>
@endsection
