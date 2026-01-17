<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',            // Заголовок поста
        'content',          // Текст
        'slug',             // URL
        'meta_title',       // <title>
        'meta_description', // <meta name="description">
        'image',            // OG image
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }



}
