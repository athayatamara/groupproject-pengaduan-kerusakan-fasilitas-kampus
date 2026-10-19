@extends('layouts.app')

@section('title', 'Statistik & Cetak')

@section('content')
    <div class="page-head">
        <div>
            <h1>Statistik Laporan</h1>
            <p>Rekap seluruh laporan kerusakan fasilitas sebagai bahan evaluasi kampus.</p>
        </div>
        <button type="button" class="btn no-print" onclick="window.print()">@include('partials.icon', ['name' => 'printer']) Cetak laporan</button>
    </div>

    <div class="stats">
        <div class="stat stat-total"><span class="stat-icon">@include('partials.icon', ['name' => 'file-text'])</span><div><div class="stat-value">{{ $total }}</div><div class="stat-label">Total laporan</div></div></div>
        <div class="stat stat-menunggu"><span class="stat-icon">@include('partials.icon', ['name' => 'clock'])</span><div><div class="stat-value">{{ $perStatus['menunggu'] ?? 0 }}</div><div class="stat-label">Menunggu</div></div></div>
        <div class="stat stat-selesai"><span class="stat-icon">@include('partials.icon', ['name' => 'check-circle'])</span><div><div class="stat-value">{{ $perStatus['selesai'] ?? 0 }}</div><div class="stat-label">Selesai</div></div></div>
        <div class="stat stat-ditolak"><span class="stat-icon">@include('partials.icon', ['name' => 'x-circle'])</span><div><div class="stat-value">{{ $perStatus['ditolak'] ?? 0 }}</div><div class="stat-label">Ditolak</div></div></div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-head"><h2>Berdasarkan status</h2></div>
            <div class="card-body">
                @foreach (\App\Models\Report::STATUS as $kunci => $label)
                    @php($jml = $perStatus[$kunci] ?? 0)
                    <div class="bar-row">
                        <span>{{ $label }}</span>
                        <div class="bar"><span class="c-{{ $kunci }}" style="width: {{ $total ? round($jml / $total * 100) : 0 }}%"></span></div>
                        <span class="val">{{ $jml }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h2>Berdasarkan urgensi</h2></div>
            <div class="card-body">
                @foreach (\App\Models\Report::URGENSI as $kunci => $label)
                    @php($jml = $perUrgensi[$kunci] ?? 0)
                    <div class="bar-row">
                        <span>{{ $label }}</span>
                        <div class="bar"><span style="width: {{ $total ? round($jml / $total * 100) : 0 }}%"></span></div>
                        <span class="val">{{ $jml }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h2>Berdasarkan kategori</h2></div>
            <div class="card-body">
                @foreach ($perKategori as $item)
                    <div class="bar-row">
                        <span>{{ $item->name }}</span>
                        <div class="bar"><span style="width: {{ $total ? round($item->reports_count / $total * 100) : 0 }}%"></span></div>
                        <span class="val">{{ $item->reports_count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h2>Berdasarkan lokasi</h2></div>
            <div class="card-body">
                @foreach ($perLokasi as $item)
                    <div class="bar-row">
                        <span>{{ $item->name }}</span>
                        <div class="bar"><span style="width: {{ $total ? round($item->reports_count / $total * 100) : 0 }}%"></span></div>
                        <span class="val">{{ $item->reports_count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
