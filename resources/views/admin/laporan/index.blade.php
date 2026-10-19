@extends('layouts.app')

@section('title', 'Laporan Masuk')

@section('content')
    <div class="page-head">
        <div>
            <h1>Laporan Masuk</h1>
            <p>Cari dan filter seluruh laporan kerusakan dari mahasiswa dan dosen/tendik.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="filters">
                <div class="field grow">
                    <label for="q">Cari judul / nama pelapor</label>
                    <input type="text" id="q" name="q" value="{{ $q }}" class="input" placeholder="Ketik kata kunci">
                </div>
                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="input">
                        <option value="">Semua status</option>
                        @foreach (\App\Models\Report::STATUS as $kunci => $label)
                            <option value="{{ $kunci }}" @selected($status === $kunci)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id" class="input">
                        <option value="">Semua kategori</option>
                        @foreach ($daftarKategori as $k)
                            <option value="{{ $k->id }}" @selected((string) $kategori === (string) $k->id)>{{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="urgency">Urgensi</label>
                    <select id="urgency" name="urgency" class="input">
                        <option value="">Semua urgensi</option>
                        @foreach (\App\Models\Report::URGENSI as $kunci => $label)
                            <option value="{{ $kunci }}" @selected($urgensi === $kunci)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn">@include('partials.icon', ['name' => 'search']) Terapkan</button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">Reset</a>
            </form>
        </div>

        @if ($laporan->isEmpty())
            @include('partials.empty-state', ['judul' => 'Laporan tidak ditemukan', 'teks' => 'Coba ubah kata kunci atau filter.'])
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Urgensi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $item)
                            <tr>
                                <td class="num">{{ $laporan->firstItem() + $loop->index }}</td>
                                <td><a href="{{ route('laporan.show', $item) }}" class="title">{{ $item->title }}</a></td>
                                <td>{{ $item->user->name }}<small>{{ $item->user->role_label }}</small></td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->location->name }}</td>
                                <td>@include('partials.badge-urgensi', ['urgensi' => $item->urgency])</td>
                                <td>@include('partials.badge-status', ['status' => $item->status])</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td><a href="{{ route('laporan.show', $item) }}" class="btn btn-outline btn-sm">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $laporan->links('vendor.pagination.simple') }}
        @endif
    </div>
@endsection
