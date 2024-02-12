<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Models\Comment;
use Webkul\Shop\Repositories\ThemeCustomizationRepository;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
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
    public function index()
    {
        $blogs = Blog::where('status', 1)->paginate(9);

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        $categories = Category::where('status', 1)->get();

        $tags = $this->gelTagsWithCount();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations', 'tags'));
    }

    public function authorPage($author_id)
    {
        $author_data = Blog::where('author_id', $author_id)->firstOrFail();

        $blogs = Blog::where('author_id', $author_id)->where('status', 1)->paginate(9);

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        $categories = Category::where('status', 1)->get();

        $tags = $this->gelTagsWithCount();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations', 'tags', 'author_data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function view($blog_slug, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $blog_id = ( $blog && !empty($blog) && !is_null($blog) ) ? (int)$blog->id : 0;

        $blog_tags = Tag::whereIn('id', explode(',',$blog->tags))->get();

        $related_blogs = Blog::where('status', 1)->whereNotIn('id', [$blog_id])->paginate(4);

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        $categories = Category::where('status', 1)->get();

        $tags = $this->gelTagsWithCount();
        
        $comments = $this->gelCommentsRecursive($blog_id);

        $total_comments = Comment::where('post', $blog_id)->where('status', 2)->get();

        $total_comments_cnt = ( !empty( $total_comments ) && count( $total_comments ) > 0 ) ? $total_comments->count() : 0;

        return view($this->_config['view'], compact('blog', 'categories', 'tags', 'comments', 'total_comments', 'total_comments_cnt', 'related_blogs', 'blog_tags'));
    }

    public function gelTagsWithCount()
    {
        $blogTags = Blog::select('*')->get()->pluck('tags')->toarray();
        $allBlogTags_arr = explode(',', implode(',', $blogTags));
        $allBlogTags_arr = ( !empty($allBlogTags_arr) && count($allBlogTags_arr) > 0 ) ? $allBlogTags_arr : array();
        $allBlogTags_arr_el_count = array_count_values($allBlogTags_arr);
        $tags = Tag::where('status', 1)->get()->each(function ($item) use ($allBlogTags_arr, $allBlogTags_arr_el_count) {
            $item->count = 0;
            $tag_id = ( $item && isset($item->id) && !empty($item->id) && !is_null($item->id) ) ? (int)$item->id : 0;
            if (count($allBlogTags_arr_el_count) > 0 && (int)$tag_id > 0) {
                $item->count = ( array_key_exists($tag_id, $allBlogTags_arr_el_count) ) ? (int)$allBlogTags_arr_el_count[$tag_id] : 0;
            }
        });

        return $tags;
    }

    public function gelCommentsRecursive($blog_id = 0, $parent_id = 0)
    {
        $comments_datas = array();

        $comments_details = Comment::where('post', $blog_id)->where('parent_id', $parent_id)->where('status', 2)->get();
        if ( !empty($comments_details) && count($comments_details) > 0 ) {
            $comments_datas = $comments_details->toarray();
            if ( !empty($comments_datas) && count($comments_datas) > 0 ) {
                foreach ($comments_datas as $key => $comments_data) {
                    $comments_datas[$key]['replay'] = $this->gelCommentsRecursive($blog_id, $comments_data['id']);
                }
            }
        }

        return $comments_datas;
    }
    
}
