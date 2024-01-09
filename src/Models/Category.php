<?php

namespace Webbycrown\BlogBagisto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webbycrown\BlogBagisto\Contracts\Category as CategoryContract;
use Illuminate\Support\Facades\Storage;

class Category extends Model implements CategoryContract
{
    use HasFactory;

    protected $table = 'blog_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
        'locale',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_at',
        'updated_at'
    ];

    /**
     * Appends.
     *
     * @var array
     */
    protected $appends = ['image_url'];

    public function blog()
    {
        return $this->hasMany(Blog::class, 'default_category');
    }

    /**
     * Get image url for the category image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return;
        }

        return Storage::url($this->image);
    }

}