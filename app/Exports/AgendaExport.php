<?php

namespace App\Exports;

use App\Models\Agenda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AgendaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private int $rowNumber = 0;

    public function collection()
    {
        return Agenda::with(['user', 'room'])->orderBy('start_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Waktu Mulai',
            'Waktu Selesai',
            'Judul Agenda',
            'Deskripsi',
            'Ruangan',
            'Dibuat Oleh',
            'Status',
        ];
    }

    public function map($agenda): array
    {
        $this->rowNumber++;

        $startTime = $agenda->start_time;
        if ($startTime instanceof \Carbon\CarbonInterface) {
            $startTimeFormatted = $startTime->format('H:i');
        } elseif (!empty($startTime)) {
            $startTimeFormatted = \Carbon\Carbon::parse($startTime)->format('H:i');
        } else {
            $startTimeFormatted = '-';
        }

        $endTime = $agenda->end_time;
        if ($endTime instanceof \Carbon\CarbonInterface) {
            $endTimeFormatted = $endTime->format('H:i');
        } elseif (!empty($endTime)) {
            $endTimeFormatted = \Carbon\Carbon::parse($endTime)->format('H:i');
        } else {
            $endTimeFormatted = '-';
        }

        return [
            $this->rowNumber,
            $agenda->start_date ? $agenda->start_date->format('d/m/Y') : '-',
            $agenda->end_date ? $agenda->end_date->format('d/m/Y') : '-',
            $startTimeFormatted,
            $endTimeFormatted,
            $agenda->title ?? '-',
            $agenda->description ?? '-',
            $agenda->room ? $agenda->room->name : '-',
            $agenda->user ? $agenda->user->name : '-',
            $agenda->status ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
