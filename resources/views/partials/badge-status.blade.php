@php
    $peta = [
        'menunggu' => ['Menunggu', 'warn'],
        'diverifikasi' => ['Diverifikasi', 'info'],
        'diproses' => ['Diproses', 'info'],
        'selesai' => ['Selesai', 'ok'],
        'ditolak' => ['Ditolak', 'bad'],
    ];
    [$teks, $kelas] = $peta[$status] ?? [ucfirst($status), 'gray'];
@endphp
<span class="badge badge-{{ $kelas }}">{{ $teks }}</span>
