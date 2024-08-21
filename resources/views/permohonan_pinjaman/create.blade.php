@extends('layouts/master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Form Permohonan Pinjaman</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Form Permohonan Pinjaman</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="card p-5 col-12">

            <h1>Permohonan Pinjaman Barang</h1>
            <form action="{{ route('permohonan.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                </div>
                
            <div class="form-group">
                <label for="divisi">Divisi</label>
                <input type="text" class="form-control" id="divisi" name="divisi" value="{{ old('divisi') }}" required>
            </div>
            
            <div class="form-group">
                <label for="barang_id">Nama Barang</label>
                <select id="barang_id" name="barang_id" class="form-control" required>
                    @foreach ($barangs as $b)
                        <option value="{{ $b->id }}" data-quantity="{{ $b->jumlah_barang }}">
                            {{ $b->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="jumlah_barang">Jumlah Barang</label>
                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" min="1" required>
                <small id="quantityHelp" class="form-text text-muted">Jumlah maksimal: 0</small>
            </div>
            
            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal_dikembalikan">Tanggal Dikembalikan</label>
                <input type="date" class="form-control" id="tanggal_dikembalikan" name="tanggal_dikembalikan" value="{{ old('tanggal_dikembalikan') }}" required>
            </div>
            
            <div class="form-group">
                <label for="alasan">Alasan</label>
                <textarea class="form-control" id="alasan" name="alasan" rows="3" required>{{ old('alasan') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
        </form>
    </div>
    </div>

    <!-- Script -->
    <script>
        document.getElementById('barang_id').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var maxQuantity = selectedOption.getAttribute('data-quantity');
            var jumlahBarangInput = document.getElementById('jumlah_barang');
            jumlahBarangInput.setAttribute('max', maxQuantity);
            document.getElementById('quantityHelp').textContent = 'Jumlah maksimal: ' + maxQuantity;

            if (parseInt(jumlahBarangInput.value) > maxQuantity) {
                jumlahBarangInput.value = maxQuantity;
            }
        });

        document.getElementById('jumlah_barang').addEventListener('input', function () {
            var maxQuantity = parseInt(document.getElementById('barang_id').options[document.getElementById('barang_id').selectedIndex].getAttribute('data-quantity'));
            if (parseInt(this.value) > maxQuantity) {
                this.value = maxQuantity;
            }
        });

        window.addEventListener('load', function () {
            var selectedOption = document.getElementById('barang_id').options[document.getElementById('barang_id').selectedIndex];
            var maxQuantity = selectedOption.getAttribute('data-quantity');
            document.getElementById('jumlah_barang').setAttribute('max', maxQuantity);
            document.getElementById('quantityHelp').textContent = 'Jumlah maksimal: ' + maxQuantity;

            var jumlahBarangInput = document.getElementById('jumlah_barang');
            if (parseInt(jumlahBarangInput.value) > maxQuantity) {
                jumlahBarangInput.value = maxQuantity;
            }
        });
    </script>
</div>
@endsection
