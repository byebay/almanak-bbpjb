<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
    <thead>
        <tr>
            <th colspan="2" style="font-size: 14px; font-weight: bold; text-align: center;">
                {{ $title }}
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #d1d5db; border: 1px solid #000;">
                @if($period === 'daily') Tanggal @elseif($period === 'monthly') Bulan @else Tahun @endif
            </th>
            <th style="font-weight: bold; background-color: #d1d5db; border: 1px solid #000;">Jumlah Pengunjung</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stats as $stat)
            <tr>
                <td style="border: 1px solid #000;">
                    @if($period === 'daily')
                        {{ \Carbon\Carbon::parse($stat->date)->translatedFormat('d F Y') }}
                    @elseif($period === 'monthly')
                        {{ \Carbon\Carbon::parse($stat->month . '-01')->translatedFormat('F Y') }}
                    @else
                        {{ $stat->year }}
                    @endif
                </td>
                <td style="border: 1px solid #000;">{{ $stat->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
