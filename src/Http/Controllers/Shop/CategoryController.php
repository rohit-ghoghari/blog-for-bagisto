<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webkul\Shop\Repositories\ThemeCustomizationRepository;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ThemeCustomizationRepository $themeCustomizationRepository)
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index($category_slug)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();

        $category_id = ( $category && isset($category->id) ) ? $category->id : 0;

        // $blogs = Blog::where('status', 1)->where('default_category', $category_id)->orWhereRaw('FIND_IN_SET(?, categorys)', [$category_id])

        $blogs = Blog::where('status', 1)
        ->where(
            function ($query) use ($category_id) {
                $query->where('default_category', $category_id)
                ->orWhereRaw('FIND_IN_SET(?, categorys)', [$category_id]);
            })
        ->paginate(9);

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        $categories = Category::where('status', 1)->get();

        $tags = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->gelTagsWithCount();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations', 'category', 'tags'));
    }
    
}
