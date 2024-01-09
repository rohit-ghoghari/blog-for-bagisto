<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.blog.edit-title')
    </x-slot:title>

    @php
        $currentLocale = core()->getRequestedLocale();
    @endphp
    
    <!-- Blog Edit Form -->
    <x-admin::form
        :action="route('admin.blog.update', $blog->id)"
        method="POST"
        enctype="multipart/form-data"
    >

        {!! view_render_event('admin.blogs.edit.before') !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::app.blog.edit-title')
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.blog.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                >
                    @lang('admin::app.catalog.categories.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('blog::app.blog.edit-btn-title')
                </button>
            </div>
        </div>

        <!-- Filter Row -->
        <div class="flex  gap-4 justify-between items-center mt-7 max-md:flex-wrap">
            <div class="flex gap-x-1 items-center">
                <!-- Locale Switcher -->

                <x-admin::dropdown :class="core()->getAllLocales()->count() <= 1 ? 'hidden' : ''">
                    <!-- Dropdown Toggler -->
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="transparent-button px-1 py-1.5 hover:bg-gray-200 dark:hover:bg-gray-800 focus:bg-gray-200 dark:focus:bg-gray-800 dark:text-white"
                        >
                            <span class="icon-language text-2xl"></span>

                            {{ $currentLocale->name }}

                            <input type="hidden" name="locale" value="{{ $currentLocale->code }}"/>

                            <span class="icon-sort-down text-2xl"></span>
                        </button>
                    </x-slot:toggle>

                    <!-- Dropdown Content -->
                    <x-slot:content class="!p-0">
                        @foreach (core()->getAllLocales() as $locale)
                            <a
                                href="?{{ Arr::query(['locale' => $locale->code]) }}"
                                class="flex gap-2.5 px-5 py-2 text-base cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 dark:text-white {{ $locale->code == $currentLocale->code ? 'bg-gray-100 dark:bg-gray-950' : ''}}"
                            >
                                {{ $locale->name }}
                            </a>
                        @endforeach
                    </x-slot:content>
                </x-admin::dropdown>
            </div>
        </div>

        <!-- Full Pannel -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">

            <!-- Left Section -->
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">

                <!-- General -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="mb-4 text-base text-gray-800 dark:text-white font-semibold">
                        @lang('admin::app.catalog.categories.create.general')
                    </p>

                    <!-- Locales -->
                    <x-admin::form.control-group.control
                        type="hidden"
                        name="locale"
                        value="en"
                    >
                    </x-admin::form.control-group.control>

                    <!-- Channel -->
                    <x-admin::form.control-group.control
                        type="hidden"
                        name="channels"
                        value="1"
                    >
                    </x-admin::form.control-group.control>

                    <!-- Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.blog.name')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="name"
                            value="{{ old('name') ?? $blog->name }}"
                            label="{{ trans('blog::app.blog.name') }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="text"
                                name="name"
                                id="name"
                                v-bind="field"
                                :class="[errors['{{ 'name' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ trans('blog::app.blog.name') }}"
                                v-slugify-target:slug="setValues"
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="name"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Slug -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.catalog.categories.create.slug')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="slug"
                            value="{{ old('slug') ?? $blog->slug }}"
                            label="{{ trans('admin::app.catalog.categories.create.slug') }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="text"
                                name="slug"
                                id="slug"
                                v-bind="field"
                                :class="[errors['{{ 'slug' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ trans('admin::app.catalog.categories.create.slug') }}"
                                v-slugify-target:slug
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="slug"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>

                <!-- Description and images -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="mb-4 text-base text-gray-800 dark:text-white font-semibold">
                        @lang('blog::app.blog.description-and-images')
                    </p>

                    <!-- Meta Description -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.blog.short_description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="short_description"
                            id="short_description"
                            rules="required"
                            :value="old('short_description') ?? $blog->short_description"
                            :label="trans('blog::app.blog.short_description')"
                            :placeholder="trans('blog::app.blog.short_description')"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="short_description"></x-admin::form.control-group.error>

                    </x-admin::form.control-group>

                    <!-- Description -->
                    <v-description>
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.description')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="description"
                                id="description"
                                class="description"
                                rules="required"
                                :value="old('description') ?? $blog->description"
                                :label="trans('blog::app.blog.description')"
                                :tinymce="true"
                                :prompt="core()->getConfigData('general.magic_ai.content_generation.category_description_prompt')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error
                                control-name="description"
                            >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>
                    </v-description>

                    <div class="flex gap-12">
                        <!-- Add Logo -->
                        <div class="flex flex-col gap-2 w-2/5 mt-5">
                            <p class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.blog.image')
                            </p>

                            <p class="text-xs text-gray-500">
                                @lang('admin::app.catalog.categories.create.logo-size')
                            </p>

                            <x-admin::media.images 
                                name="src" 
                                :uploaded-images="$blog->src ? [['id' => 'src', 'url' => $blog->src_url]] : []"
                            >
                                
                            </x-admin::media.images>

                        </div>

                    </div>
                </div>

                <!-- SEO Deatils -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('blog::app.blog.search_engine_optimization')
                    </p>

                    <!-- SEO Title & Description Blade Componnet -->
                    <x-admin::seo/>

                    <div class="mt-8">
                        <!-- Meta Title -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.meta_title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="meta_title"
                                id="meta_title"
                                rules="required"
                                :value="old('meta_title') ?? $blog->meta_title"
                                :label="trans('blog::app.blog.meta_title')"
                                :placeholder="trans('blog::app.blog.meta_title')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_title"></x-admin::form.control-group.error>

                        </x-admin::form.control-group>

                        <!-- Meta Keywords -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.meta_keywords')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="meta_keywords"
                                rules="required"
                                :value="old('meta_keywords') ?? $blog->meta_keywords"
                                :label="trans('blog::app.blog.meta_keywords')"
                                :placeholder="trans('blog::app.blog.meta_keywords')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_keywords"></x-admin::form.control-group.error>

                        </x-admin::form.control-group>

                        <!-- Meta Description -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.meta_description')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="meta_description"
                                id="meta_description"
                                rules="required"
                                :value="old('meta_description') ?? $blog->meta_description"
                                :label="trans('blog::app.blog.meta_description')"
                                :placeholder="trans('blog::app.blog.meta_description')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_description"></x-admin::form.control-group.error>

                        </x-admin::form.control-group>
                    </div>
                </div>

            </div>

            <!-- Right Section -->
            <div class="flex flex-col gap-2 w-[360px] max-w-full">
                <!-- Settings -->

                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-gray-600 dark:text-gray-300 text-base font-semibold">
                            @lang('admin::app.catalog.categories.create.settings')
                        </p>
                    </x-slot:header>

                    <x-slot:content>

                        <!-- Published At -->
                        <x-admin::form.control-group class="w-full mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.published_at')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="date"
                                name="published_at" 
                                id="published_at"
                                rules="required"
                                :value="old('published_at') ?? date_format(date_create($blog->published_at),'Y-m-d')"
                                :label="trans('blog::app.blog.published_at')"
                                :placeholder="trans('blog::app.blog.published_at')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error
                                control-name="published_at"
                            >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>

                        <!-- Status -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.blog.status')
                            </x-admin::form.control-group.label>

                            @php $selectedValue_status = old('status') ?: $blog->status @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                name="status"
                                class="cursor-pointer"
                                value="1"
                                :label="trans('blog::app.blog.status')"
                                :checked="(boolean) $selectedValue_status"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        <!-- Allow Comments -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.blog.allow_comments')
                            </x-admin::form.control-group.label>

                            @php $selectedValue_allow_comments = old('allow_comments') ?: $blog->allow_comments @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                name="allow_comments"
                                class="cursor-pointer"
                                value="1"
                                :label="trans('blog::app.blog.allow_comments')"
                                :checked="(boolean) $selectedValue_allow_comments"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        <!-- Auther -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required text-gray-800 dark:text-white font-medium required">
                                @lang('blog::app.blog.author')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="select"
                                name="author"
                                id="author"
                                {{-- class="cursor-pointer" --}}
                                rules="required"
                                :value="old('author') ?? $blog->author"
                                :label="trans('blog::app.blog.author')"
                                {{-- :placeholder="trans('blog::app.blog.author')" --}}
                            >
                                <!-- Options -->
                                <option value="">Select an author</option>
                                @foreach($users as $user)
                                    <option value="{{$user->name}}">{{$user->name}}</option>
                                @endforeach
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error
                                control-name="author"
                            >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>

                    </x-slot:content>
                </x-admin::accordion>

                <!-- Categories & Tags -->
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="required text-gray-600 dark:text-gray-300 text-base p-2.5 font-semibold">
                            @lang('blog::app.blog.categories_title')
                        </p>
                    </x-slot:header>

                    <x-slot:content>

                        <!-- Category -->
                        <x-admin::form.control-group class="mb-2.5">

                            <x-admin::form.control-group.control
                                type="select"
                                name="default_category"
                                id="default_category"
                                {{-- class="cursor-pointer" --}}
                                rules="required"
                                :value="old('default_category') ?? $blog->default_category"
                                :label="trans('blog::app.blog.default_category')"
                            >
                                <!-- Options -->
                                <option value="">Select an category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ $blog->default_category == $category->id ? 'selected' : '' }} >{{$category->name}}</option>
                                @endforeach
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error
                                control-name="default_category"
                            >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>

                    </x-slot:content>
                </x-admin::accordion>

                <!-- Tags -->
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="required text-gray-600 dark:text-gray-300 text-base p-2.5 font-semibold">
                            @lang('blog::app.blog.tag_title')
                        </p>
                    </x-slot:header>

                    <x-slot:content>
                        @foreach ($tags as $tag)
                            <x-admin::form.control-group class="flex gap-2.5 !mb-0 p-1.5">
                                <x-admin::form.control-group.control
                                    type="checkbox"
                                    name="tags[]"
                                    :id="$tag->name"
                                    :value="$tag->id"
                                    rules="required"
                                    :for="$tag->name"
                                    :label="trans('blog::app.blog.tags')"
                                    :checked="in_array($tag->id, explode(',', $blog->tags))"
                                >
                                </x-admin::form.control-group.control>

                                <x-admin::form.control-group.label
                                    :for="$tag->name"
                                    class="!text-sm !text-gray-600 dark:!text-gray-300 font-semibold cursor-pointer"
                                >
                                    {{ $tag->name }}
                                </x-admin::form.control-group.label>
                            </x-admin::form.control-group>
                        @endforeach

                        <x-admin::form.control-group.error
                            control-name="tags[]"
                        >
                        </x-admin::form.control-group.error>
                    </x-slot:content>
                </x-admin::accordion>

                {!! view_render_event('admin.blogs.edit.after', ['blogs' => $blog]) !!}

            </div>
        </div>

    </x-admin::form>

</x-admin::layouts>