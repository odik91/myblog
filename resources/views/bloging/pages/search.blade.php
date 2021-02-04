@extends('bloging.layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="container">
  <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
    <div class="f2-s-1 p-r-30 m-tb-6">
      <a href="{{ route('article.index') }}" class="breadcrumb-item f1-s-3 cl9">
        Home
      </a>

      <span class="breadcrumb-item f1-s-3 cl9">
        {{ $title }}
      </span>
    </div>

    <form action="{{ route('article.search') }}" method="GET">
      <div class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
        <input class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45" type="text" name="search" placeholder="Search">
        <button type="submit" class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03">
          <i class="zmdi zmdi-search"></i>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Page heading -->
<div class="container p-t-4 p-b-40">
  <h2 class="f1-l-1 cl2">
    Result List
  </h2>
</div>

<!-- Post -->
<section class="bg0 p-b-55">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8 p-b-80">
        <div class="p-r-10 p-r-0-sr991">
          <div class="m-t--40 p-b-40" id="latestPost">
            @if (count($results) > 0)
              @foreach ($results as $result)
              <!-- Item post -->
              <div class="flex-wr-sb-s p-t-40 p-b-15 how-bor2">
                <a href="{{ route('article.view', [$result['slug']]) }}" class="size-w-8 wrap-pic-w hov1 trans-03 w-full-sr575 m-b-25">
                  <img src="{{ asset('post/' . $result['image']) }}" alt="IMG">
                </a>

                <div class="size-w-9 w-full-sr575 m-b-25">
                  <h5 class="p-b-12">
                    <a href="{{ route('article.view', [$result['slug']]) }}" class="f1-l-1 cl2 hov-cl10 trans-03 respon2">
                      {{ ucfirst($result['title']) }}
                    </a>
                  </h5>

                  <div class="cl8 p-b-18">
                    <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                      By {{ ucwords($result->getUser['name']) }}
                    </a>

                    <span class="f1-s-3 m-rl-3">
                      -
                    </span>

                    <span class="f1-s-3 m-rl-3">
                      <a href="{{ route('article.category', [$result['slug']]) }}" class="f1-s-4 cl8 hov-cl10 trans-03">
                        {{ ucwords($result->getCategory['name']) }}
                      </a>
                    </span>
                    
                    <span class="f1-s-3 m-rl-3">
                      -
                    </span>

                    <span class="f1-s-3">
                      {{ date_format(date_create(substr($result['created_at'], 0, (strlen($result['created_at']) - 9))), "D, d M Y") }}
                    </span>
                  </div>

                  <p class="f1-s-1 cl6 p-b-24">
                    {!! strip_tags(substr($result['content'], 0, 150)) !!}...
                  </p>

                  <a href="{{ route('article.view', [$result['slug']]) }}" class="f1-s-1 cl9 hov-cl10 trans-03">
                    Read More
                    <i class="m-l-2 fa fa-long-arrow-alt-right"></i>
                  </a>
                </div>
              </div>
              @endforeach
            @else 
            <div class="flex-wr-sb-s p-t-40 p-b-15 how-bor2">
              <h3>Sorry, we couldn't find what you wanted...</h3>
            </div>
            @endif
          </div>
          <div class="flex-wr-c-c m-rl--7 p-t-15">
            {{-- {{ $results->links() }} --}}
            {{ $results->appends(Illuminate\Support\Facades\Request::except('page'))->links() }}
          </div>
        </div>
      </div>      

      @include('bloging.layouts.sidebar2')
    </div>
  </div>
</section>
@endsection

@push('addon-css')
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css"
  href="{{ asset('posting/fonts/fontawesome-5.0.8/css/fontawesome-all.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css"
  href="{{ asset('posting/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/css/util.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/css/main.css') }}">
<!--===============================================================================================-->
<style>
  .article-content p {
    line-height: 1, 8px;
    padding-bottom: 25px;
    text-align: justify;
  }

  .article-content h2 {
    line-height: 1, 8px;
    padding-bottom: 25px;
    text-align: center;
    font-weight: 600;
  }
</style>
@endpush

@push('addon-script')
<!--===============================================================================================-->
<script src="{{ asset('posting/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('posting/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('posting/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('posting/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('posting/js/main.js') }}"></script>
@endpush