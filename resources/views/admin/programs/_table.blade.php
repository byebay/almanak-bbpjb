<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="w-64 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Program</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wilayah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tim Kerja</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 [&>tr>td]:align-top">
            @forelse ($programs as $program)
                <tr>
                    <td class="w-64 px-6 py-4 align-top text-sm text-gray-900 whitespace-normal break-words">{{ $program->nama_program }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $program->wilayah?->nama_wilayah ?? 'Tidak ditentukan' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $program->tim_kerja ?: '-' }}
                        @if($program->sub_tim_kerja)
                            <span class="text-xs text-gray-500 block">({{ $program->sub_tim_kerja }})</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $program->tanggal_mulai ? \Carbon\Carbon::parse($program->tanggal_mulai)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $program->tanggal_selesai ? \Carbon\Carbon::parse($program->tanggal_selesai)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center">
                            <a href="{{ route('admin.programs.show', $program) }}" class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm border border-gray-200 shadow-sm">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        @if ($search)
                            Tidak ada program yang cocok dengan pencarian "{{ $search }}".
                        @else
                            Belum ada data program.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($programs->hasPages())
    <div class="mt-6">
        {{ $programs->links() }}
    </div>
@endif