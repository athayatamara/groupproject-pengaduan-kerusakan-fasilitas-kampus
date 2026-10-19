@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route($rute . '.index') }}" class="muted">&larr; Kembali ke daftar</a>
            <h1 style="margin-top:8px">{{ $judul }}</h1>
        </div>
    </div>

    <form action="{{ $item->exists ? route($rute . '.update', $item) : route($rute . '.store') }}" method="POST" class="card" style="max-width:560px" data-loading>
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="field">
                <label for="name">Nama {{ $tunggal }} <span class="req">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" maxlength="100" class="input @error('name') is-invalid @enderror" autofocus>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <a href="{{ route($rute . '.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </div>
    </form>
@endsection
