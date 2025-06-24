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
    
  <title>Berita Acara Kelulusan</title>
</head>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }
    .tabel{
        border-collapse: collapse;
        
    }
    .tabel th {
        border: 1px solid black;
        padding: 15px;
    }
    .tabel td {
        border: 1px solid black;
        padding: 15px;
    }
    .tabel th{
        background-color: aqua;
    }
    p,li{
        text-align: justify;
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
        function terbilang($angka) {
            $angka = abs($angka);
            $bilangan = array(
                '',
                'Satu',
                'Dua',
                'Tiga',
                'Empat',
                'Lima',
                'Enam',
                'Tujuh',
                'Delapan',
                'Sembilan',
                'Sepuluh',
                'Sebelas'
            );
            $temp = '';
            if ($angka < 12) {
                $temp = ' ' . $bilangan[$angka];
            } else if ($angka < 20) {
                $temp = terbilang($angka - 10) . ' Belas';
            } else if ($angka < 100) {
                $temp = terbilang($angka / 10) . ' Puluh' . terbilang($angka % 10);
            } else if ($angka < 200) {
                $temp = ' Seratus' . terbilang($angka - 100);
            } else if ($angka < 1000) {
                $temp = terbilang($angka / 100) . ' Ratus' . terbilang($angka % 100);
            } else if ($angka < 2000) {
                $temp = ' Seribu' . terbilang($angka - 1000);
            } else if ($angka < 1000000) {
                $temp = terbilang($angka / 1000) . ' Ribu' . terbilang($angka % 1000);
            } else if ($angka < 1000000000) {
                $temp = terbilang($angka / 1000000) . ' Juta' . terbilang($angka % 1000000);
            } else if ($angka < 1000000000000) {
                $temp = terbilang($angka / 1000000000) . ' Milyar' . terbilang(fmod($angka, 1000000000));
            } else if ($angka < 1000000000000000) {
                $temp = terbilang($angka / 1000000000000) . ' Trilyun' . terbilang(fmod($angka, 1000000000000));
            }
            return $temp;
        }


        /////Konversi Tanggal
        $pecah = explode('-', now()->toDateString());
        $tahun = $pecah[0];
        $bulan = $pecah[1];
        $hari = $pecah[2];

        // Array untuk nama bulan dalam bahasa Indonesia
        $namaBulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        // Konversi angka bulan menjadi nama bulan dalam bahasa Indonesia
        $bulanIndo = $namaBulan[$bulan];

        // Konversi angka hari menjadi nama hari dalam bahasa Indonesia
        $hariIndo = terbilang($hari);

        // Konversi angka tahun menjadi kata dalam bahasa Indonesia
        $tahunIndo = terbilang($tahun);

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
        <h4 style="text-align: center;">BERITA ACARA RAPAT EVALUASI KELULUSAN</h4>
        <h4 style="text-align: center;margin-top: -20px;">PELATIHAN {{ strtoupper($pelatihan->nama) }}</h4>
        <h4 style="text-align: center;margin-top: -20px;">(<i>{{ strtoupper($pelatihan->model_pelatihan->nama) }}</i>)</h4>

        <p style="text-align: center;white-space: pre;margin-top: -10px;">NOMOR  : {{ $request->nomor_surat }}</p>
      </div>
      <div class="isi-surat">
        <p>Pada hari ini <b>{{ hari_indo(now()->toDateString()) }}</b> tanggal <b>{{ $hariIndo }}</b> bulan <b>{{ $bulanIndo }}</b> tahun <b>{{ $tahunIndo }}</b>, kami:</p>
        <ol>
            @foreach ($data as $item)
            
                <li>{{ $item['nama_lengkap'] }} (NIP. {{ $item['nip'] }}) selaku {{ $item['jabatan'] }} {{ $item['unit_kerja'] }}{{ $loop->last? '.' : ';' }}</li>
            @endforeach
        </ol>
        <p>
            Telah melaksanakan rapat evaluasi kelulusan Peserta Pelatihan {{ ucwords($pelatihan->nama) }} ({{ $pelatihan->model_pelatihan->nama }}) yang dilaksanakan oleh Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya pada tanggal {{ rentang_tgl($pelatihan->tanggal_mulai, $pelatihan->tanggal_selesai) }} dengan hasil sebagai berikut :
            <ol>
                <li>Jumlah peserta pelatihan sebanyak {{ $request->jumlah_peserta }} ({{ terbilang($request->jumlah_peserta) }}) orang;</li>
                <li>Sebanyak {{ $request->memuaskan }} ({{ terbilang($request->memuaskan) }}) orang lulus dengan predikat <b>“memuaskan”</b>;</li>
                <li>Sebanyak {{ $request->baik_sekali }} ({{ terbilang($request->baik_sekali) }}) orang lulus dengan predikat <b>“baik sekali”</b>;</li>
                <li>Sebanyak {{ $request->baik }} ({{ terbilang($request->baik) }}) orang lulus dengan predikat <b>“baik”</b>.</li>
            </ol>
            Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya.
        </p>

        <h3 style="text-align: center;page-break-before:always">MENYETUJUI</h3>
        <table class="tabel">
            <tr>
                <td style="text-align: center">No.</td>
                <td style="text-align: center">Nama Lengkap</td>
                <td style="text-align: center">Jabatan</td>
                <td style="text-align: center">Unit Kerja</td>
                <td style="text-align: center">Tanda Tangan</td>
            </tr>
            @foreach ($data as $item){
                @if ($item['nama_lengkap'] != null)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['nama_lengkap'] }}</td>
                    <td>{{ $item['jabatan'] }}</td>
                    <td>{{ $item['unit_kerja'] }}</td>
                    <td style="white-space: pre;">                      </td>
                </tr>
                @endif
            }
            @endforeach
        </table>

      </div>
    </div>
  </div>
</body>
<script>
    // window.print();
</script>

</html>