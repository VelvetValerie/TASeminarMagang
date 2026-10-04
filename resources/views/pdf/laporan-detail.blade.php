<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - {{ $laporan->kegiatan->nama_keg ?? 'Kegiatan' }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0 0;
            font-size: 11px;
        }
        table.table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.table-info th, table.table-info td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }
        table.table-info th {
            background-color: #f2f2f2;
            width: 30%;
        }
        .footer {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 15px; font-weight: bold; cursor: pointer;">🖨️ Cetak PDF</button>
        <button onclick="window.close()" style="padding: 8px 15px; font-weight: bold; cursor: pointer;">✕ Tutup</button>
    </div>

    <div class="header">
        <h2>KANTOR REGIONAL BKN VIII BANJARBARU</h2>
        <p>LAPORAN HASIL PELAKSANAAN DAN EVALUASI KEGIATAN</p>
    </div>

    <table class="table-info">
        <tr>
            <th>NAMA KEGIATAN</th>
            <td><strong>{{ $laporan->kegiatan->nama_keg ?? '-' }}</strong></td>
        </tr>
        <tr>
            <th>JENIS KEGIATAN</th>
            <td>{{ $laporan->kegiatan->jenis->nama_jeniskeg ?? '-' }}</td>
        </tr>
        <tr>
            <th>LOKASI & INSTANSI</th>
            <td>{{ $laporan->kegiatan->lokasi->nm_lokasi ?? '-' }} | {{ $laporan->kegiatan->instansi->nm_instansi ?? '-' }}</td>
        </tr>
        <tr>
            <th>KOORDINATOR KEGIATAN</th>
            <td>{{ $laporan->kegiatan->koordinator->nama_karyawan ?? '-' }}</td>
        </tr>
        <tr>
            <th>PESERTA HADIR</th>
            <td>{{ number_format($laporan->peserta_hadir) }} Orang</td>
        </tr>
        <tr>
            <th>PESERTA ABSEN</th>
            <td>{{ number_format($laporan->peserta_tidak_hadir) }} Orang</td>
        </tr>
        <tr>
            <th>NILAI TERTINGGI / TERENDAH</th>
            <td>Max: {{ $laporan->nilai_tertinggi ?? '-' }} | Min: {{ $laporan->nilai_terendah ?? '-' }}</td>
        </tr>
        <tr>
            <th>CATATAN EVALUASI</th>
            <td>{{ $laporan->catatan_evaluasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>TANGGAL LAPORAN</th>
            <td>{{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y H:i') }} WITA</td>
        </tr>
    </table>

    <div class="footer">
        <p>Banjarbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Koordinator Kegiatan,</p>
        <br><br><br>
        <p><strong><u>{{ $laporan->kegiatan->koordinator->nama_karyawan ?? '.........................' }}</u></strong></p>
    </div>

</body>
</html>