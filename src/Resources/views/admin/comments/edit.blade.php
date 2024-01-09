<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.comment.edit-title')
    </x-slot:title>

    @php
        $currentLocale = core()->getRequestedLocale();
    @endphp
    
    <!-- Blog Edit Form -->
    <x-admin::form
        :action="route('admin.blog.comment.update', $comment->id)"
        method="POST"
        enctype="multipart/form-data"
    >

        {!! view_render_event('admin.blog.comments.edit.before') !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::app.comment.edit-title')
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
                    @lang('blog::app.comment.edit-btn-title')
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

                    <!-- Author ID -->
                    <x-admin::form.control-group.control
                        type="hidden"
                        name="author"
                        :value="$comment->author"
                    >
                    </x-admin::form.control-group.control>

                    <!-- Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.comment.post')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="post"
                            value="{{ old('post') ?? $comment->blog->name }}"
                            label="{{ trans('blog::app.comment.post') }}"
                            rules="required"
                            v-slot="{ field }"
                            disabled="disabled"
                        >
                            <input
                                type="text"
                                name="post"
                                id="post"
                                v-bind="field"
                                :class="[errors['{{ 'post' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ trans('blog::app.comment.post') }}"
                                v-slugify-target:slug="setValues"
                                disabled="disabled"
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="post"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Slug -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.comment.name')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="author_name"
                            value="{{ old('author_name') ?? $author_name }}"
                            label="{{ trans('blog::app.comment.name') }}"
                            rules="required"
                            v-slot="{ field }"
                            disabled="disabled"
                        >
                            <input
                                type="text"
                                name="author_name"
                                id="author_name"
                                v-bind="field"
                                :class="[errors['{{ 'author_name' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ trans('blog::app.comment.name') }}"
                                v-slugify-target:slug
                                disabled="disabled"
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="author_name"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Published At -->
                    <x-admin::form.control-group class="w-full mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.comment.comment_date')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="date"
                            name="created_at" 
                            id="created_at"
                            rules="required"
                            disabled="disabled"
                            :value="old('created_at') ?? date_format(date_create($comment->created_at),'Y-m-d')"
                            :label="trans('blog::app.comment.comment_date')"
                            :placeholder="trans('blog::app.comment.comment_date')"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="created_at"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Description -->
                    <v-description>
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.comment.comment')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="comment"
                                id="comment"
                                class="comment"
                                rules="required"
                                :value="old('comment') ?? $comment->comment"
                                :label="trans('blog::app.comment.comment')"
                                :tinymce="true"
                                :prompt="core()->getConfigData('general.magic_ai.content_generation.category_description_prompt')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error
                                control-name="comment"
                            >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>
                    </v-description>

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
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.comment.status')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="select"
                                name="status"
                                id="status"
                                {{-- class="cursor-pointer" --}}
                                :value="old('status') ?? $comment->status"
                                :label="trans('blog::app.comment.status')"
                            >
                                <!-- Options -->
                                @foreach($status_details as $status_data)
                                    <option value="{{$status_data['id']}}" {{ $comment->status == $status_data['id'] ? 'selected' : '' }} >@lang($status_data['name'])</option>
                                @endforeach
                            </x-admin::form.control-group.control>

                        </x-admin::form.control-group>

                    </x-slot:content>
                </x-admin::accordion>

                {!! view_render_event('admin.blog.comments.edit.after', ['comment' => $comment]) !!}

            </div>
        </div>

    </x-admin::form>

</x-admin::layouts>