@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
@include('layout.sidebar')
@endsection

@section('content')
<div class="app-content">
    @if(Session::has('success'))
        <p>ok</p>
        <script>
            Swal.fire({
                title: '{{ Session::get('popUp_title') }}',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <div class="content-wrapper">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <table id="datatable1" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelatihan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pelatihans as $pelatihan)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>
                                    <img src="{{ asset('assets/images/bidang_pelatihan/' . $pelatihan->bidang_pelatihan->gambar) }}" width="35" > 
                                    {{ $pelatihan->nama }}
                                </td>
                                <td>
                                    <script>
                                        function cetak_button_{{ $pelatihan->id }}() {
                                            Swal.fire({
                                            title: "Konfirmasi Pencetakan Surat",
                                            text: "Apakah Anda ingin melakukan cetak surat untuk pelatihan ini? ",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonText: "Batal",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Menuju Cetak Menu"
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "/cetak-surat/pelatihan-{{ $pelatihan->id }}";
                                            }
                                            });
                                        }
                                    </script>
                                    <a onclick="cetak_button_{{ $pelatihan->id }}();" class="btn btn-primary btn-sm"><i class="material-icons-outlined center" sty>print</i></a> 
                                </td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
@endsection

