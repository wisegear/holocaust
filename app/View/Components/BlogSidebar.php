<?php

namespace App\View\Components;

use Illuminate\View\Component;
use DB;

class BlogSidebar extends Component
{

    public $categories;
    public $featured;
    public $unpublished;
    public $popular_tags;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = \App\Models\BlogCategories::with('BlogPosts')->get();
        $this->featured = \App\Models\BlogPosts::with('Users')->where('featured', true)->orderBy('created_at', 'desc')->limit(3)->get();
        $this->unpublished = \App\Models\BlogPosts::where('published', false)->get();
        $this->popular_tags = DB::table('post_tags')
        ->leftjoin('blog_tags', 'blog_tags.id', '=', 'post_tags.tag_id')
        ->select('post_tags.tag_id', 'name', DB::raw('count(*) as total'))
        ->groupBy('post_tags.tag_id', 'name')
        ->orderBy('total', 'desc')
        ->limit(15)
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
       return view('components.blog-sidebar');
    }
}
