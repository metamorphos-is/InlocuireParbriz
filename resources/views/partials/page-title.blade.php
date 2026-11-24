<section class="ee-pagehead">
    <div class="container">
        @if (!empty($crumbs))
            <nav aria-label="Breadcrumb" class="ee-crumbs">
                <ol>
                    @foreach ($crumbs as [$label, $href])
                        <li>@if ($href)<a href="{{ $href }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1 class="ee-pagehead__title">{{ $title }}</h1>
        @if (!empty($lead))
            <p class="ee-pagehead__lead">{{ $lead }}</p>
        @endif
    </div>
</section>
