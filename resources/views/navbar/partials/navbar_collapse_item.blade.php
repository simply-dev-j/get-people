@php
    $title = $title ?? '';
    $link = $link ?? '#';
    $class = $class ?? 'col-12';
@endphp

<div class="navbar-collapse-item {{$class}}">
    <a href="{{ $link }}">
        {!! $title !!}
    </a>
</div>
