<?php

namespace Webbycrown\BlogBagisto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webbycrown\BlogBagisto\Contracts\Blog as BlogContract;
use Webkul\Core\Models\ChannelProxy;
use Illuminate\Support\Facades\Storage;

class Blog extends Model implements BlogContract
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'channels',
        'default_category',
        'author',
        'tags',
        'src',
        'status',
        'locale',
        'allow_comments',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at'
    ];

    /**
     * Appends.
     *
     * @var array
     */
    protected $appends = ['src_url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'default_category');
    }

    /**
     * Get the channels.
     */
    public function channels()
    {
        return $this->belongsToMany(ChannelProxy::modelClass(), 'channels');
    }

    /**
     * Get image url for the category image.
     *
     * @return string
     */
    public function getSrcUrlAttribute()
    {
        if (! $this->src) {
            return;
        }

        return Storage::url($this->src);
    }

}