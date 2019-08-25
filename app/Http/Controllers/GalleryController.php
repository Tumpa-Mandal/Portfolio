<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class GalleryController extends Controller
{
    private $table='galeries';
    //List Gallery

    public function index(){

        //Get All Gallery Cover Image
    	$galleries=DB::table($this->table)->get();

        //Render The View
    	return view('gallery/index',compact('galleries'));
    }

    //Show Create Form

    public function create(){
        //check logged in
        if (!Auth::check()) {
            return \Redirect::route('gallery.index');
        }

    	return view('gallery/create');
    }

    //Store Gallery

    public function store(Request $request){
        $name        = $request->input('name');
        $description = $request->input('description');
        $cover_image = $request->file('cover_image');
        $owner_id    = 1;

        //check image upload

        if ($cover_image) {

          $cover_image_filename = $cover_image->getClientOriginalName();
           $cover_image->move(public_path('images'), $cover_image_filename);

        } else {

           $cover_image_filename = 'noimages.jpg';
        }

        //Insert Gallery Image

        DB::table($this->table)->insert(

            [

             'name'        => $name,
             'description' => $description,
             'cover_image' => $cover_image_filename,
             'owner_id'    => $owner_id
            ]

        );
        
        //Set Message

        \Session::flash('message','Gallery Created');

        //redirect

        return \Redirect::route('gallery.index');
    }

    //Show Gallery Photo

    public function show($id){
        //Get Gallery
    	$gallery=DB::table($this->table)->where('id',$id)->first();

        //Get Photos
        $photos=DB::table('photos')->where('gallery_id',$id)->get();

        //Render The View
        return view('gallery/show',compact('gallery','photos'));

    }
}
