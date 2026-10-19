@php
    $peta = ['rendah' => 'ok', 'sedang' => 'warn', 'tinggi' => 'bad'];
@endphp
<span class="badge badge-{{ $peta[$urgensi] ?? 'gray' }}">{{ ucfirst($urgensi) }}</span>
