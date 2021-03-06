<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryCategories;
use App\Models\GalleryAlbums;
use File;
use Str;

class GalleryAlbumsController extends Controller
{
    public $gallery_path = '/images/gallery';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $get_category = $_GET['category'];

        $albums = GalleryAlbums::where('gallery_categories_id', $get_category)->get();
        $category = GalleryCategories::find($get_category);

        return view('admin.gallery.albums', compact('albums', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $album = new GalleryAlbums;
        $album->name = $request->new_album_name;
        $album->slug = Str::slug($request->new_album_name, '-');

        $album->gallery_categories_id = $request->category;

        $categoryName = GalleryCategories::find($request->category);

        File::MakeDirectory(public_path() . $this->gallery_path . '/' . strToLower($categoryName->name) . '/' . strToLower($request->new_album_name));

        $album->save();

        return back();        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $albums = GalleryAlbums::with('galleryCategories')->where('id', '=', $id)->get();

        return view('admin.gallery.albums', compact('albums'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $album = GalleryAlbums::find($id);
        $category = GalleryCategories::find($album->gallery_categories_id);
            // Move the file before changing the DB Record
            File::Move(public_path() . $this->gallery_path . '/' . strtolower($category->name) . '/' . strToLower($album->name),
                       public_path() . $this->gallery_path . '/' . strtolower($category->name) . '/' . strToLower($request->album_name));

        $album->name = $request->album_name;
        $album->slug = Str::slug($request->album_name, '-');
        $album->description = $request->album_description;

        $album->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = GalleryAlbums::find($id);
        $category = GalleryCategories::find($album->gallery_categories_id);

        // Delete the directory before removing DB record
        File::DeleteDirectory(public_path() . $this->gallery_path . '/' . strtolower($category->name) . '/' . strtolower($album->name));

        GalleryAlbums::destroy($id);

        return back();
    }
}
