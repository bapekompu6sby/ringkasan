<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
  <title>Report Progress</title>
</head>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }
</style>

<body>
  @if (!function_exists('tanggal_indo'))
    @php
    function tanggal_indo($tanggal){
        $bulan = array (
        1 =>'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    function rentang_tgl($tgl_mulai, $tgl_selesai){
        $tgl_mulai = tanggal_indo($tgl_mulai);
        $tgl_selesai = tanggal_indo($tgl_selesai);
        $tgl_mulai_pecah = explode(' ', $tgl_mulai);
        $tgl_selesai_pecah = explode(' ', $tgl_selesai);
        if ($tgl_mulai_pecah[1] == $tgl_selesai_pecah[1]) {
            return $tgl_mulai_pecah[0] . ' s.d ' . $tgl_selesai_pecah[0] . ' ' . $tgl_mulai_pecah[1] . ' ' . $tgl_mulai_pecah[2];
        }
        return $tgl_mulai . ' s.d ' . $tgl_selesai;
    }

    function hari_indo($tanggal){
        if (date('l', strtotime($tanggal)) == 'Sunday') {
            return 'Minggu';
        } elseif (date('l', strtotime($tanggal)) == 'Monday') {
            return 'Senin';
        } elseif (date('l', strtotime($tanggal)) == 'Tuesday') {
            return 'Selasa';
        } elseif (date('l', strtotime($tanggal)) == 'Wednesday') {
            return 'Rabu';
        } elseif (date('l', strtotime($tanggal)) == 'Thursday') {
            return 'Kamis';
        } elseif (date('l', strtotime($tanggal)) == 'Friday') {
            return 'Jumat';
        } elseif (date('l', strtotime($tanggal)) == 'Saturday') {
            return 'Sabtu';
        }
        return date('l', strtotime($tanggal));
    }
    @endphp
@endif
  <div class="container">
    <div class="kopsurat"
      style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid black;">
      <img style="text-align:left" src="{{ asset('assets/images/pupr.png') }}" alt="" width="100" height="100">
      <div class="heading" style="text-align: center; margin-left: 10px;">
        <h4 style="margin-top: 20px;">KEMENTERIAN PEKERJAAN UMUM</h4>
        <h4 style="margin-top: -20px;font-weight:normal">BADAN PENGEMBANGAN SUMBER DAYA MANUSIA</h4>
        <h4 style="margin-top: -20px;">BALAI PENGEMBANGAN KOMPETENSI PEKERJAAN UMUM WILAYAH VI SURABAYA</h4>
        <h6 style="margin-top: -20px;font-weight:normal">Jalan Gayung Kebonsari 48, Gayungan, Surabaya 60234, Telepon (031) 8291040, 8286501 Faksimili 8275847</h6>
      </div>
    </div>
    <div class="isi">
      <div class="judul" style="text-align: center;">
        <h2>SURAT KETERANGAN</h2>
        <h3 style="border-bottom: 1px solid black; width: fit-content; margin: auto;">PROGRES PELAKSANAAN PELATIHAN</h3>
        <p style="margin-top: 5px;">Nomor: </p>
      </div>
      <div class="isi-surat">
        @php
          $pointer = 0;
        @endphp
        <ol type="A">
          @foreach($sop_kegiatans as $sop_kegiatan)
            <li>
              <h4 style="margin-bottom: 1px;">{{ $sop_kegiatan[0]->sop->judul }}</h4>
              <table width="90%">
                @foreach ($sop_kegiatan as $kegiatan )
                <tr>
                  <td width="20px">{{ $loop->iteration }}.</td>
                  <td width="400px" style="vertical-align: top">{{ $kegiatan->nama }}</td>
                  <td>:</td>
                  <td style="text-align: right;">
                    @if ($detil_status->contains('id_kegiatan_sop', $kegiatan->id))
                      [ ✔ ]
                    @else
                      [ X ]
                    @endif
                  </td>
                </tr>
                @endforeach
              </table>

              <!-- Model 2 -->
              <!-- <table width="90%">
                @foreach ($sop_kegiatan as $kegiatan )
                  @if ($detil_status->contains('id_kegiatan_sop', $kegiatan->id))
                    <tr>
                      <td width="400px">{{ $kegiatan->nama }}</td>
                      <td>:</td>
                      <td style="text-align: right;">[ ✔ ]</td>
                    </tr>
                  @endif
                @endforeach
              </table> -->
            </li>
          @endforeach
        </ol>
        <p style="text-indent:50px;line-height:1.5">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya, atas perhatian disampaikan terimakasih.</p>
      </div>
    </div>
    <div class="ttd" style="display: flex; justify-content: flex-end;">
      <div class="ttd-koprodi" style="position: relative;">
        <p style="margin-bottom: 20px; text-align:right;">Surabaya, {{ tanggal_indo(now()->toDateString()) }}
        </p>
        <p style="line-height:1.5;text-align:center;">Mengetahui,
        </p>
        <p style="line-height:1.5;text-align:center;">Kepala Seksi Penyelenggara 
          <br>
          Balai Kompetensi Pekerjaan Umum WILAYAH VI Surabaya</p>
        </p>
        <p style="margin-top: 100px;text-align:center;">.......................................</p>
        <p style="margin-top: -20px;text-align:center;">NIP. 123456789</p>
      </div>
    </div>
  </div>
</body>
<script>
  // window.print();
</script>

</html>