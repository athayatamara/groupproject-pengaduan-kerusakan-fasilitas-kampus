<div class="empty">
    @include('partials.icon', ['name' => $ikon ?? 'inbox'])
    <h3>{{ $judul }}</h3>
    <p>{{ $teks ?? '' }}</p>
    @isset($tautan)
        <a href="{{ $tautan }}" class="btn">{{ $label }}</a>
    @endisset
</div>
