@if ($status === 'selesai')
    <span class="badge badge-selesai">Selesai</span>
@elseif ($status === 'diproses')
    <span class="badge badge-proses">Diproses</span>
@elseif ($status === 'diverifikasi')
    <span class="badge badge-proses">Diverifikasi</span>
@elseif ($status === 'ditolak')
    <span class="badge badge-tolak">Ditolak</span>
@else
    <span class="badge badge-tunggu">Menunggu</span>
@endif
