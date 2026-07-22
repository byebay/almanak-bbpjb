<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="2" style="font-weight: bold; font-size: 14px; text-align: center; background-color: #DBEAFE;">REKAPITULASI PENGUNJUNG HARIAN</th>
            </tr>
            <tr>
                <th style="font-weight: bold; background-color: #93C5FD; border: 1px solid #000;">Tanggal</th>
                <th style="font-weight: bold; background-color: #93C5FD; border: 1px solid #000;">Jumlah Pengunjung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyStats as $stat)
                <tr>
                    <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($stat->date)->translatedFormat('d F Y') }}</td>
                    <td style="border: 1px solid #000;">{{ $stat->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th colspan="2" style="font-weight: bold; font-size: 14px; text-align: center; background-color: #DBEAFE;">REKAPITULASI PENGUNJUNG BULANAN</th>
            </tr>
            <tr>
                <th style="font-weight: bold; background-color: #93C5FD; border: 1px solid #000;">Bulan</th>
                <th style="font-weight: bold; background-color: #93C5FD; border: 1px solid #000;">Jumlah Pengunjung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyStats as $stat)
                <tr>
                    <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($stat->month . '-01')->translatedFormat('F Y') }}</td>
                    <td style="border: 1px solid #000;">{{ $stat->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th colspan="2" style="font-weight: bold; font-size: 14px; text-align: center; background-color: #DBEAFE;">REKAPITULASI PENGUNJUNG TAHUNAN</th>
            </tr>
            <tr>
                <th style="font-weight: bold; background-color: #93C5FD; border: 1px solid #000;">Tahun</th>
                <th style="font-weight: bold; background-color: #93C5FD; border: 1px solid #000;">Jumlah Pengunjung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($yearlyStats as $stat)
                <tr>
                    <td style="border: 1px solid #000;">{{ $stat->year }}</td>
                    <td style="border: 1px solid #000;">{{ $stat->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
