<?php

namespace Webbycrown\BlogBagisto\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Webbycrown\BlogBagisto\Validations\BlogTagUniqueSlug;

class BlogTagRequest extends FormRequest
{
    /**
     * Determine if the Configuration is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locale = core()->getRequestedLocaleCode();
        $locale = ( is_array( $locale ) && count( $locale ) > 0 ) ? $locale[0] : 'en';

        if ($id = request('id')) {
            return [
                'slug'              => ['required', new BlogTagUniqueSlug('blog_tags', $id)],
                'name'              => 'required',
                'description'       => 'required',
                'meta_title'        => 'required',
                'meta_description'  => 'required',
                'meta_keywords'     => 'required',
            ];
        }

        return [
            'slug'              => ['required', new BlogTagUniqueSlug],
            'name'              => 'required',
            'description'       => 'required',
            'meta_title'        => 'required',
            'meta_description'  => 'required',
            'meta_keywords'     => 'required',
        ];
    }
}
