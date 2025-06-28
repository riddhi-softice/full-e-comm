@extends('web.layouts2.app')
@section('content')

<div class="mb-6"></div><!-- End .mb-6 -->

<div class="mb-5"></div><!-- End .mb-5 -->

<div class="container">

    <div class="tab-content">
        <!-- All Products Tab -->
        <div class="tab-pane fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
            <div class="row justify-content-center">
                @foreach ($data['all_products'] as $product)
                @include('web.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <nav aria-label="Page navigation">
            @php
            $paginator = $data['all_products'];
            @endphp

            @if ($paginator->lastPage() > 1)
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link page-link-prev" href="{{ $paginator->previousPageUrl() ?? '#' }}"
                        aria-label="Previous">
                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                    </a>
                </li>

                {{-- Page Number Links --}}
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
                @endfor

                {{-- Total Page Display --}}
                <li class="page-item-total">of {{ $paginator->lastPage() }}</li>

                {{-- Next Page Link --}}
                <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link page-link-next" href="{{ $paginator->nextPageUrl() ?? '#' }}"
                        aria-label="Next">
                        Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
            @endif
        </nav>
    </div>
</div><!-- End .tab-content -->

@endsection
@section('javascript')
@endsection