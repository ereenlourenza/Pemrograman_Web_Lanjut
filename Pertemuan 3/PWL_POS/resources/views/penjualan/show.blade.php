@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($penjualan)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $penjualan->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>Pembeli</th>
                        <td>{{ $penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan Kode</th>
                        <td>{{ $penjualan->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan Tanggal</th>
                        <td>{{ date('d-m-Y', strtotime($penjualan->penjualan_tanggal)) }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $penjualan->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Barang Dibeli</th>
                        <td>
                            <ul>
                                @foreach ($penjualan_detail as $item)
                                    <li> {{ $item->barang->barang_nama }} ({{ $item->jumlah }} pcs) = {{ $item->harga * $item->jumlah }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>
                            <?php $total = 0?>
                            @foreach ($penjualan_detail as $item)
                                {{ $total += $item->harga*$item->jumlah }}
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endempty
            
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush    