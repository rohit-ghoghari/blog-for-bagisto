@php
    $channel = core()->getCurrentChannel();
@endphp


{{-- SEO Meta Content --}}
@push ('meta')
    <meta name="title" content="{{ ( isset( $tag->meta_title ) && !empty( $tag->meta_title ) && !is_null( $tag->meta_title ) ) ? $tag->meta_title : ( $channel->home_seo['meta_title'] ?? '' ) }}" />

    <meta name="description" content="{{ ( isset( $tag->meta_description ) && !empty( $tag->meta_description ) && !is_null( $tag->meta_description ) ) ? $tag->meta_description : ( $channel->home_seo['meta_description'] ?? '' ) }}" />

    <meta name="keywords" content="{{ ( isset( $tag->meta_keywords ) && !empty( $tag->meta_keywords ) && !is_null( $tag->meta_keywords ) ) ? $tag->meta_keywords : ( $channel->home_seo['meta_keywords'] ?? '' ) }}" />
@endPush

<x-shop::layouts>
    {{-- Page Title --}}
    <x-slot:title>
        {{ __('Blog Tag Page') }}
    </x-slot>

    @push ('styles')

        @include ('blog::custom-css.custom-css')

    @endpush

    <div class="main">

        <div>
            <div class="row col-12 remove-padding-margin"><!---->
                <div id="home-right-bar-container" class="col-12 no-padding content">
                    <div class="container-right row no-margin col-12 no-padding">
                        <div id="blog" class="container mt-5">
                            <div class="full-content-wrapper">
                                <!-- <div class="col-lg-12"><h1 class="mb-3 page-title">Our Blog</h1></div> -->
                                <section class="blog-hero-wrapper">
                                    <div class="blog-hero-image">
                                        <h1 class="hero-main-title">{{ $tag->name }}</h1>
                                        <img
                                        src="{{ '/storage/placeholder-banner.jpg' }}"
                                        alt=""
                                        class="card-img img-fluid img-thumbnail bg-fill">
                                    </div>
                                </section>
                                <div class="flex flex-wrap grid-wrap">

                                    <div class="column-12">
                                        <div class="text-justify blog-post-content">
                                            {!! $tag->description !!}
                                        </div>
                                    </div>
                                    
                                    <div class="column-9">
                                        <div class="flex flex-wrap blog-grid-list">

                                            @foreach($blogs as $blog)
                                                <div class="blog-post-item">
                                                    <div class="blog-post-box">
                                                        <div class="card mb-5">
                                                            <div class="blog-grid-img"><img
                                                                src="{{ '/storage/' . ( ( isset($blog->src) && !empty($blog->src) && !is_null($blog->src) ) ? $blog->src : 'placeholder-thumb.jpg' ) }}"
                                                                alt="{{ $blog->name }}"
                                                                class="card-img-top">
                                                            </div>
                                                            <div class="card-body">
                                                                <h2 class="card-title"><a href="{{route('shop.article.view',[$blog->category->slug . '/' . $blog->slug])}}">{{ $blog->name }}</a></h2>
                                                                <div class="post-meta">
                                                                    <p>
                                                                        {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('M j, Y') }} by
                                                                        <a href="{{route('shop.blog.author.index',[$blog->author_id])}}">{{ $blog->author }}</a>
                                                                    </p>
                                                                </div>

                                                                @if( !empty($blog->assign_categorys) && count($blog->assign_categorys) > 0 )
                                                                    <div class="post-categories">
                                                                        <p>
                                                                            @foreach($blog->assign_categorys as $assign_category)
                                                                                <a href="{{route('shop.blog.category.index',[$assign_category->slug])}}" class="cat-link">{{$assign_category->name}}</a>
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                <div class="card-text text-justify">
                                                                    {!! $blog->short_description !!}
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <a href="{{route('shop.article.view',[$blog->category->slug . '/' . $blog->slug])}}" class="text-uppercase btn-text-link">Read more ></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="w-full col-lg-12 mt-5 mb-5">
                                                {!! $blogs->links() !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class=" column-3 blog-sidebar">
                                        <div class="row">
                                            <div class="col-lg-12 mb-4 categories"><h3>Categories</h3>
                                                <ul class="list-group">
                                                    @foreach($categories as $category)
                                                        {{-- <li><a href="{{route('shop.blog.category.index',[$category->category->slug])}}" class="list-group-item list-group-item-action">
                                                                <span>{{ $category->category->name }}</span> <span class="badge badge-pill badge-primary">{{ $category->count }}</span>
                                                        </a></li> --}}
                                                        <li><a href="{{route('shop.blog.category.index',[$category->slug])}}" class="list-group-item list-group-item-action">
                                                                <span>{{ $category->name }}</span> <span class="badge badge-pill badge-primary">{{ $category->assign_blogs }}</span>
                                                        </a></li>
                                                    @endforeach
                                                </ul>

                                                <div class="tags-part">
                                                    <h3>Tags</h3> 
                                                    <div class="tag-list">
                                                        @foreach($tags as $tag)
                                                            <a href="{{route('shop.blog.tag.index',[$tag->slug])}}" role="button" class="btn btn-primary btn-lg">{{ $tag->name }} <span class="badge badge-light">{{ $tag->count }}</span></a> 
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-shop::layouts>
