{{-- @extends('admin::layouts.master')

@section('page_title')
    {{ __('blog::app.blog.title') }}
@stop

@section('content-wrapper')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('blog::app.blog.title') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>

                    <span>
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>

                <a href="{{ route('admin.blog.create') }}" class="btn btn-lg btn-primary">
                    {{ __('blog::app.blog.add-title') }}
                </a>
            </div>

            <div class="page-action">
                <date-filter></date-filter>

            </div>

            <date-mobile-filter></date-mobile-filter>
        </div>

        <div class="page-content">
            <datagrid-plus src="{{ route('admin.blog.index') }}"></datagrid-plus>
        </div>
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>

        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>

@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => app('Webbycrown\BlogBagisto\DataGrids\BlogDataGrid')])
@endpush --}}

<x-admin::layouts>
    <x-slot:title>
        {{-- @lang('admin::app.catalog.categories.index.title') --}}
        {{ __('Blogs') }}
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            {{-- @lang('admin::app.catalog.categories.index.title') --}}
            {{ __('Blogs') }}
        </p>

        <div class="flex gap-x-2.5 items-center">
            @if (bouncer()->hasPermission('catalog.categories.create'))
                <a href="{{ route('admin.blog.create') }}">
                    <div class="primary-button">
                        {{-- @lang('admin::app.catalog.categories.index.add-btn') --}}
                        {{ __('Create Blog') }}
                    </div>
                </a>
            @endif
        </div>        
    </div>

    {!! view_render_event('bagisto.admin.catalog.categories.list.before') !!}

    <x-admin::datagrid src="{{ route('admin.blog.index') }}"></x-admin::datagrid>

    {!! view_render_event('bagisto.admin.catalog.categories.list.after') !!}

</x-admin::layouts>