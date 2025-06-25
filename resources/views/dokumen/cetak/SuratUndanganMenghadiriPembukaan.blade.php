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
  <title>Surat Undangan Menghadiri Pembukaan</title>
</head>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }
  td{
    word-wrap: break-word;
  }
  /* @media print {
    td {
      word-wrap: break-word;
      vertical-align: top !important;
    }
  } */
  p,li{
      text-align: justify
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
    <div class="kopsurat" style="border-bottom: 1px solid black;">
      <div class="wrapper">
        <img style="background-color: blue;" src="{{ $logo }}" alt="pupr" width="100" height="100">
        <div class="heading" style="text-align: center; width: 80%; float: right;">
          <h4 style="margin-top: 5px;margin-left: -80px;">KEMENTERIAN PEKERJAAN UMUM</h4>
          <h4 style="margin-top: -20px;margin-left: -80px;font-weight:normal">BADAN PENGEMBANGAN SUMBER DAYA MANUSIA</h4>
          <h4 style="margin-top: -20px;margin-left: -80px;">BALAI PENGEMBANGAN KOMPETENSI PEKERJAAN UMUM WILAYAH VI SURABAYA</h4>
          <h6 style="margin-top: -20px;margin-left: -80px;font-weight:normal">Jalan Gayung Kebonsari 48, Gayungan, Surabaya 60234, Telepon (031) 8291040, 8286501 Faksimili 8275847</h6>
        </div>
      </div>
    </div>
    <br>
    <div class="isi">
      <div class="judul">
        <p style="margin-bottom: 20px; margin-top: -5px; text-align:right;">Surabaya, {{ tanggal_indo(now()->toDateString()) }}
        </p>
        <table style="margin-top: -30px;">
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $request->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Biasa</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td style="word-wrap: break-word;vertical-align:top">Permohonan Menghadiri Pembukaan Pelatihan {{ $pelatihan->nama }}</td>
            </tr>
        </table>
      </div>
      <div class="isi-surat">
        <p><b>Yth. {{ $request->nama_yth }}</b> <br>di Tempat</p>

        <p style="text-indent: 50px; line-height: 1.5;">
          Sehubungan dengan Pelatihan {{ $pelatihan->nama }} yang akan dilaksanakan pada tanggal {{ rentang_tgl($pelatihan->tanggal_mulai, $pelatihan->tanggal_selesai) }} secara {{ $pelatihan->model_pelatihan->nama }} di Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya, mohon kesediaan {{ $request->kata_ganti }} untuk berkenan menghadiri pembukaan kegiatan dimaksud yang akan dilaksanakan pada:
        </p>
        <table style="margin-left: 20px;">
          <tr>
            <td style="width: 120px;">Hari/tanggal</td>
            <td>:</td>
            <td>{{ hari_indo($pelatihan->tanggal_mulai) }}/ {{ tanggal_indo($pelatihan->tanggal_mulai) }}</td>
          </tr>
          <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>Pukul {{ $request->waktu_mulai }} WIB s.d selesai</td>
          </tr>
          <tr>
            <td>Media</td>
            <td>:</td>
            <td>
                <i>Zoom Meeting ID</i> : <b>{{ $request->zoom_id }}</b> <i>Passcode</i> : <b>{{ $request->passcode }}</b>
            </td>
          </tr>
        </table>
        <p style="text-indent: 50px;line-height: 1.5;">Demikian kami sampaikan, atas perhatian dan perkenan {{ $request->kata_ganti }}, kami mengucapkan terimakasih.</p>
      </div>
    </div>
    <div class="ttd" style="position: relative; margin-bottom: 250px;">
      <div class="ttd-koprodi" style="position: absolute; width: 50%; right: 0; top: 20px;">
        <p style="margin-top: -20px; text-align:center;"><b>Kepala Balai Pengembangan Kompetensi Pekerjaan Umum
            <br>Wilayah VI Surabaya,</b>
        </p>
        <p style="margin-top: 100px;text-align:center;"><b>Diki Zulkarnaen, ST, M.Sc.</b></p>
        <p style="margin-top: -10px;text-align:center;">NIP. 197904182005021001</p>
        <p style="margin-top: -10px;text-align:center;"><i style="color:rgb(151, 149, 149)">Ditandatangani secara elektronik</i></p>
      </div>
    </div>
    <div style="page-break-inside: avoid">
      <p><b>Tembusan:</b></p>
      <ol>
        @foreach($data as $item)
          @if ($item['tembusan'] != null)
            <li>{{ $item['tembusan'] }}{{ $loop->last? '.' : ';' }}</li>
          @endif
        @endforeach
      </ol>
    </div>
  </div>
</body>
<script>
  // window.print();
</script>

</html>