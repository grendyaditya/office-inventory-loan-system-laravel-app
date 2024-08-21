@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <h1>Edit Barang</h1>

            <form action="{{ route('barang.update', $barang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_barang">Jumlah Barang</label>
                    <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="{{ old('jumlah_barang', $barang->jumlah_barang) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
