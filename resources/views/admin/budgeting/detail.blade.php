@extends('admin.layouts2.master')
@section('title', 'Detail Create Paket')


@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    {!! Toastr::message() !!}
    @foreach ($errors->all() as $error)
        {!! Toastr::error($error, 'Error', ['options']) !!}
    @endforeach


    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Paket</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('budget.index') }}">Paket</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{-- {{ dd($dataDesa) }} --}}
    <div class="page-content">
        <section class="section">
            <div class="row" id="table-hover-row">
                <div class=" col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detail Paket</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <ul>
                                    <li>Nama Paket : {{ $paket['nama_paket'] }}</li>
                                    <li>Kategori Paket :
                                        <br>
                                        @for ($i = 0; $i < count($paket['data_kategori']); $i++)
                                            {{ $paket['data_kategori'][$i]->nama_kategori }} <br>
                                        @endfor
                                    </li>
                                    <li>Jumlah Hari : {{ $paket['jml_hari'] }}</li>
                                    <li>Jumlah Orang : {{ $paket['jml_orang'] }}</li>
                                </ul>

                                <form action="{{ route('store-budget') }}" id="form" method="POST"
                                    enctype="multipart/form-data" class="form">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="admin">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Isi Paket</th>
                                                    <th scope="col">Aksi</th>
                                                    <th scope="col">Harga Satuan</th>
                                                    <th scope="col">Harga Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- {{ dd($nomor) }} --}}
                                                <?php $i = 1; ?>
                                                @foreach ($wisatas as $wisata)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $wisata->name }}</td>
                                                        <td> - </td>
                                                        <td> {{ $wisata->htm != null ? 'Rp' . number_format($wisata->htm) : 'Rp0' }}
                                                        </td>
                                                        <td> {{ $wisata->htm != null ? 'Rp' . number_format($wisata->htm) : 'Rp0' }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @foreach ($villas as $villa)
                                                    <tr>
                                                        <td> {{ $i++ }} </td>
                                                        <td>{{ $villa->nama }}</td>
                                                        <td> - </td>
                                                        <td> {{ $villa->harga != null ? 'Rp' . number_format($villa->harga) : 'Rp0' }}
                                                        </td>
                                                        <td> {{ $villa->harga != null ? 'Rp' . number_format($villa->harga) : 'Rp0' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                {{-- {{ dd($kamars) }} --}}
                                                {{-- @foreach ($hotels as $hotel) --}}
                                                <tr>
                                                    @if ($hotels != null)
                                                        <td> {{ $i++ }} </td>
                                                        <td>{{ $hotels->nama }} - {{ $kamars->name }}</td>
                                                        <td> - </td>
                                                        <td> Rp{{ number_format($kamars->harga) }} </td>
                                                        <td> Rp{{ number_format($kamars->harga) }} </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if ($guide != null)
                                                        <td> {{ $i++ }} </td>
                                                        <td> Tour Guide: {{ $guide->name }} </td>
                                                        <td> - </td>
                                                        <td> Rp{{ number_format($guide->harga) }} </td>
                                                        <td> Rp{{ number_format($guide->harga) }} </td>
                                                    @endif
                                                </tr>
                                                {{-- @endforeach --}}
                                                <tr>
                                                    @if ($kuliners != null)
                                                        <td>{{ $i++ }}</td>
                                                        <td> Paket Makanan {{ $kuliners->nama_paket }}</td>
                                                        <td>-</td>
                                                        <td> Rp{{ number_format($kuliners->harga) }} </td>
                                                        <td> Rp{{ number_format($kuliners->harga) }} </td>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                    <td class="d-flex justify-content-end">
                                                        <b>Total:</b>
                                                    </td>
                                    </div>
                                    <td></td>
                                    <td>Rp{{ number_format($total) }}</td>
                                    </tr>
                                    </tbody>
                                    </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="nama_paket" value="{{ $paket['nama_paket'] }}" hidden>
                                        <input type="text" name="jml_orang" value="{{ $paket['jml_orang'] }}" hidden>
                                        <input type="text" name="jml_hari" value="{{ $paket['jml_hari'] }}" hidden>
                                        <input type="number" id="hargaAwal" value="{{ $total }}" hidden>

                                        @for ($i = 0; $i < count($paket['data_kategori']); $i++)
                                            <input type="text" name="data_kategori[]"
                                                value="{{ $paket['data_kategori'][$i]->id }}" hidden>
                                        @endfor

                                        @foreach ($wisatas as $wisata)
                                            <input type="text" name="data_wisata[]" value="{{ $wisata->id }}" hidden>
                                        @endforeach

                                        {{-- {{ dd($villas) }} --}}
                                        @foreach ($villas as $villa)
                                            <input type="text" name="data_villa" value="{{ $villa->id }}" hidden>
                                        @endforeach
                                        @if ($hotels != null)
                                            <input type="text" name="data_hotel" value="{{ $hotels->id }}" hidden>
                                        @endif
                                        @if ($guide != null)
                                            <input type="text" name="data_guide" value="{{ $guide->id }}" hidden>
                                        @endif
                                        @if ($kamars != null)
                                            <input type="text" name="data_kamar" value="{{ $kamars->id }}" hidden>
                                        @endif
                                        @if ($kuliners != null)
                                            <input type="text" name="kuliner" value="{{ $kuliners->id }}" hidden>
                                        @endif

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="number" id="diskon" class="form-control mb-2"
                                            placeholder="Diskon 0-100">
                                        <input type="number" class="form-control" id="harga-akhir" name="harga" value="{{ $total }}"
                                            placeholder="Harga Akhir" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary mt-2">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <!-- Hoverable rows end -->

    </div>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#diskon', function() {
                var allGood = true;
                let diskon = parseInt($('#diskon').val());
                let harga = parseInt($('#hargaAwal').val());
                // console.log(diskon);
                console.log(harga);

                if ($(this).val() == "") {

                    console.log('false');

                    return allGood = false;

                }

                if (allGood) {
                    let hargaDiskon = harga * (diskon / 100);
                    let totalHarga = harga - hargaDiskon;
                    $('#harga-akhir').attr("value", totalHarga);
                    // console.log(totalHarga);
                }
            });
        });
    </script>
@endsection
