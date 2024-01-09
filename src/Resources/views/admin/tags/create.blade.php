<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.tag.add-title')
    </x-slot:title>

    @php
        $currentLocale = core()->getRequestedLocale();
    @endphp
    
    <!-- Blog Edit Form -->
    <x-admin::form
        :action="route('admin.blog.tag.store')"
        method="POST"
        enctype="multipart/form-data"
    >

        {!! view_render_event('admin.blog.tags.create.before') !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::app.tag.add-title')
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.blog.tag.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                >
                    @lang('admin::app.catalog.categories.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('blog::app.tag.create-btn-title')
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

                    <!-- Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.tag.name')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            label="{{ trans('blog::app.tag.name') }}"
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
                                placeholder="{{ trans('blog::app.tag.name') }}"
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
                            @lang('blog::app.tag.slug')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            label="{{ trans('blog::app.tag.slug') }}"
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
                                placeholder="{{ trans('blog::app.tag.slug') }}"
                                v-slugify-target:slug
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="slug"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Description -->
                    <v-description>
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.tag.description')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="description"
                                id="description"
                                class="description"
                                rules="required"
                                :value="old('description')"
                                :label="trans('blog::app.tag.description')"
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

                </div>

                <!-- SEO Deatils -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('blog::app.tag.search_engine_optimization')
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
                                :value="old('meta_title')"
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
                                :value="old('meta_keywords')"
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
                                :value="old('meta_description')"
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

                        <!-- Status -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.tag.status')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="switch"
                                name="status"
                                class="cursor-pointer"
                                value="1"
                                :label="trans('blog::app.tag.status')"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                    </x-slot:content>
                </x-admin::accordion>

                {!! view_render_event('admin.blog.tags.create.after') !!}

            </div>
        </div>

    </x-admin::form>

</x-admin::layouts>