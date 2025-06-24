@extends('layout.navbar')

@section('style')

@endsection

@section('sidebar')
@include('layout.sidebar')
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            {{-- <div class="section-description">
                    <h1>Recent Files</h1>
                </div> --}}

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="terkirim-tab" data-bs-toggle="tab" data-bs-target="#terkirim-dokumen" type="button" role="tab" aria-controls="terkirim-dokumen" aria-selected="false">Terkirim</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disetujui-tab" data-bs-toggle="tab" data-bs-target="#disetujui-dokumen" type="button" role="tab" aria-controls="disetujui-dokumen" aria-selected="false">Disetujui</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ditolak-tab" data-bs-toggle="tab" data-bs-target="#ditolak-dokumen" type="button" role="tab" aria-controls="ditolak-dokumen" aria-selected="false">Ditolak</button>
                </li>
            </ul>
            <br>
            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="terkirim-dokumen" role="tabpanel" aria-labelledby="terkirim-tab">
                    <div class="row mb-3">
                        <form action="/riwayat-dokumen" method="GET">
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" class="form-control" placeholder="Cari dokumen..." name="dokumen_terkirim">
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" placeholder="Cari pelatihan..." name="pelatihan_terkirim">
                                </div>
                                <div class="col-2 my-auto">
                                    <input type="submit" class="btn button btn-info" value="Cari" style="width: 100%">
                                </div>
                            </div>
                        </form>
                    </div>
                    @forelse ($terkirims as $terkirim)
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @php
                                        $split = explode('.', $terkirim->file);
                                        $ext = $split[1]
                                    @endphp
                                    @if ($ext == 'pdf')
                                        <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                    @elseif($ext == 'doc' || $ext == 'docx')
                                        <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                                    @elseif($ext == 'xlsx' || $ext == 'xls')
                                        <i class="material-icons-outlined text-success align-middle m-r-sm">description</i>
                                    @elseif($ext == 'rar' || $ext == 'zip')
                                        <i class="material-icons-outlined text-info align-middle m-r-sm">description</i>
                                    @endif
                                    <a href="{{ asset('assets/dokumen/'. $terkirim->status->pelatihan->id . '_' .$terkirim->id_kegiatan_tahapan . '.' . $ext) }}" target="_blank" class="file-manager-recent-item-title flex-fill">{{ $terkirim->kegiatan_tahapan->dokumen }}</a>
                                    <span class="p-h-sm text-muted">{{ $terkirim->status->pelatihan->nama }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <h6 class="text-muted">Tidak ada dokumen terkirim</h6>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="tab-pane fade" id="disetujui-dokumen" role="tabpanel" aria-labelledby="disetujui-tab">
                    <div class="row mb-3">
                        <form action="/riwayat-dokumen" method="GET">
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" class="form-control" placeholder="Cari dokumen..." name="dokumen_disetujui">
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" placeholder="Cari pelatihan..." name="pelatihan_disetujui">
                                </div>
                                <div class="col-2 my-auto">
                                    <input type="submit" class="btn button btn-info" value="Cari" style="width: 100%">
                                </div>
                            </div>
                        </form>
                    </div>
                    @forelse($disetujuis as $disetujui)
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @php
                                        $split = explode('.', $disetujui->file);
                                        $ext = $split[1]
                                    @endphp
                                    @if ($ext == 'pdf')
                                        <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                    @elseif($ext == 'doc' || $ext == 'docx')
                                        <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                                    @elseif($ext == 'xlsx' || $ext == 'xls')
                                        <i class="material-icons-outlined text-success align-middle m-r-sm">description</i>
                                    @elseif($ext == 'rar' || $ext == 'zip')
                                        <i class="material-icons-outlined text-info align-middle m-r-sm">description</i>
                                    @endif
                                    <a href="{{ asset('assets/dokumen/'. $disetujui->status->pelatihan->id . '_' .$disetujui->id_kegiatan_tahapan . '.' . $ext) }}" target="_blank" class="file-manager-recent-item-title flex-fill">{{ $disetujui->kegiatan_tahapan->dokumen }}</a>
                                    <span class="p-h-sm text-muted">{{ $disetujui->status->pelatihan->nama }}</span>
                                    <a class="dropdown-toggle file-manager-recent-file-actions" id="file-manager-recent-10" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="file-manager-recent-10">
                                        <li><a class="dropdown-item" href="#">Unduh</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <h6 class="text-muted">Tidak ada dokumen disetujui</h6>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="tab-pane fade" id="ditolak-dokumen" role="tabpanel" aria-labelledby="ditolak-tab">
                    <div class="row mb-3">
                        <form action="/riwayat-dokumen" method="GET">
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" class="form-control" placeholder="Cari dokumen..." name="dokumen_ditolak">
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" placeholder="Cari pelatihan..." name="pelatihan_ditolak">
                                </div>
                                <div class="col-2 my-auto">
                                    <input type="submit" class="btn button btn-info" value="Cari" style="width: 100%">
                                </div>
                            </div>
                        </form>
                    </div>
                    @forelse ($ditolaks as $ditolak)
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @php
                                        $split = explode('.', $ditolak->kegiatan_tahapan->file);
                                        $ext = count($split) > 1 ? $split[1] : ''; 
                                    @endphp
                                    @if ($ext == 'pdf')
                                        <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                    @elseif($ext == 'doc' || $ext == 'docx')
                                        <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                                    @elseif($ext == 'xlsx' || $ext == 'xls')
                                        <i class="material-icons-outlined text-success align-middle m-r-sm">description</i>
                                    @elseif($ext == 'rar' || $ext == 'zip')
                                        <i class="material-icons-outlined text-info align-middle m-r-sm">description</i>
                                    @endif
                                    <a href="{{ asset('assets/dokumen/'. $ditolak->status->pelatihan->id . '_' .$ditolak->id_kegiatan_tahapan . '.' . $ext) }}" target="_blank" class="file-manager-recent-item-title flex-fill">{{ $ditolak->kegiatan_tahapan->dokumen }}</a>
                                    <span class="p-h-sm text-muted">{{ $ditolak->status->pelatihan->nama }}</span>
                                    
                                </div>
                                <br>
                                    <p><b>Pesan:</b> <br>{{ $ditolak->komentar }}</p>
                                    @php
                                        $split_dokumen = explode('.', $ditolak->file);
                                        $split_dokumen2 = explode('_', $split_dokumen[0]);
                                        $pelatihan_id = $split_dokumen2[0];
                                        $kegiatan_id = $split_dokumen2[1];
                                        
                                    @endphp
                                    <script>
                                        function recreate_button_{{ $ditolak->id }}() {
                                                Swal.fire({
                                                title: "Konfirmasi Pembuatan Ulang Dokumen",
                                                text: "Jika Anda membuat ulang, maka file ini akan dihapus otomatis oleh sistem. Apakah Anda yakin ingin membuat ulang dokumen ini? ",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonText: "Batal",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Buat ulang"
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "re-fill-dokumen-pelatihan-{{ $pelatihan_id }}/{{ $kegiatan_id }}";
                                                }
                                                });
                                            }
                                    </script>
                                    <a onclick="recreate_button_{{ $ditolak->id }}();" type="button" class="btn btn-primary btn-small float-end">Buat ulang</a>
                            </div>
                        </div>
                    @empty
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <h6 class="text-muted">Tidak ada dokumen ditolak</h6>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

