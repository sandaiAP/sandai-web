<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['title','categories','body'];

    public function scopeGetLatest()
    {
        $news = News::latest()->take(3)->get(['id','title','categories','body']);
        return $news;
    }
}
