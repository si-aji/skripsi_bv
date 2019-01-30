@extends('layouts.template')

{{-- Needed CSS --}}
@section('needed_css')
<link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
@endsection{{-- /.Needed CSS --}}

{{-- Content --}}
@section('content')
<div class="container"><!-- Wrapper -->
    <div class="row">
        <div class="col-12 col-lg-6 mx-auto">
            <div class="card" style="margin-top:5rem">
                <div class="card-header">
                    <h2 class="card-title text-center">Website is Coming Soon</h2>
                </div>
                <div class="card-body">
                    <p class="text-center">Our Store</p>
                    @foreach ($toko as $dtoko)
                        <div class="row">
                            <div class="card col-12">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $dtoko->toko_nama }}</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-responsive table-borderless">
                                        <tbody>
                                            <tr>
                                                <th class="p-1">Tipe</th>
                                                <td class="p-1">{{ $dtoko->toko_tipe }}</td>
                                            </tr>
                                            @if(!is_null($dtoko->toko_kontak) && !empty($dtoko->toko_kontak))
                                            <tr>
                                                <th class="p-1">Kontak</th>
                                                <td class="p-1">{{ $dtoko->toko_kontak }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th class="p-1">Alamat</th>
                                                <td class="p-1">
                                                    @if((!is_null($dtoko->toko_alamat) && !empty($dtoko->toko_alamat)) && (!is_null($dtoko->toko_link) && !empty($dtoko->toko_link)))
                                                    <a href="{{ $dtoko->toko_link }}">{{ $dtoko->toko_alamat }}</a>
                                                    @elseif(!is_null($dtoko->toko_alamat) && !empty($dtoko->toko_alamat))
                                                    <p>{{ $dtoko->toko_alamat }}</p>
                                                    @elseif(!is_null($dtoko->toko_link) && !empty($dtoko->toko_link))
                                                    <a href="{{ $dtoko->toko_link }}">{{ $dtoko->toko_link }}</a>
                                                    @else
                                                    <p>-</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer text-center">
                    <div class="brand_image">
                        <img src="{{ asset('img/bv/logo.png') }}" alt="Bakulvisor Logo" style="width:20% !important">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function(){
            $('body').addClass('bg-bakulvisor-gradient');
        });
    </script>
@endsection
