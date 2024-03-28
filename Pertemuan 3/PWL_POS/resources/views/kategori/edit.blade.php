@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')

{{-- Content body: main page content --}}

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit kategori</h3>
            </div>
            
            <form method="post" action="/kategori/update/{{ $kategori->kategori_id }}">
                {{-- @method('put'); --}} {{-- kalau pakai route put--}}
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeKategori">Kode Kategori</label>
                        <input type="text" class="form-control" id="kodeKategori" value="{{ $kategori->kategori_kode }}" name="kategori_kode" placeholder="untuk makanan, contoh: MKN"/>
                    </div>
                    <div class="form-group">
                        <label for="namaKategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="namaKategori" value="{{ $kategori->kategori_nama }}"  name="kategori_nama" placeholder="Nama"/>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                @csrf
            </form>
        
        </div>
    </div>
@endsection