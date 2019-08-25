<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class PhotoController extends Controller
{
   private $table='photos'; 

    //Show Create Form
    public function create($gallery_id){
        //check logged in
        if (!Auth::check()) {
            return \Redirect::route('gallery.index');
        }

    	//Render The View
        return view('photo/create',compact('gallery_id'));
    }

    //Store Photo

    public function Store(Request $request){
        $gallery_id  = $request->input('gallery_id');
        $title       = $request->input('title');
        $description = $request->input('description');
        $location    = $request->input('location');
        $image       = $request->file('image');
        $owner_id    = 1;

        //check image upload

        if ($image) {

          $image_filename = $image->getClientOriginalName();
           $image->move(public_path('images'), $image_filename);

        } else {

           $image_filename = 'noimages.jpg';
        }

        //Insert Gallery Image

        DB::table($this->table)->insert(

            [
             
             'title'       => $title,
             'description' => $description,
             'location'    => $location,
             'gallery_id'  => $gallery_id, 
             'image'       => $image_filename,
             'owner_id'    => $owner_id
            ]

        );
        
        //Set Message

        \Session::flash('message','Portfolio Added');

        //redirect

        return \Redirect::route('gallery.show',array('id' => $gallery_id));

    }

    //Show Portfolio Details

    public function details($id){
    	//Get Photos
        $photo=DB::table($this->table)->where('id',$id)->first();

        //Render The View
        return view('photo/details',compact('photo'));
    }

//Delete Portfolio
    public function destroy($id,$gallery_id){

        $photo=DB::table($this->table)->where('id',$id)->delete();

        //Set Message

        \Session::flash('message','Portfolio Deleted Successfully');

        //redirect

        return \Redirect::route('gallery.show',array('id' => $gallery_id));


    }

    //Edit Portfolio
    public function edit($id){
         //check logged in
        if (!Auth::check()) {
            return \Redirect::route('gallery.index');
        }
        $photo=DB::table($this->table)->where('id',$id)->first();

        //Render The View
        return view('photo/edit',compact('photo'));

    }

    //Update Data

    public function updatedata(Request $request){

        $id  = $request->input('id');
        $gallery_id  = $request->input('gallery_id');
        $title       = $request->input('title');
        $description = $request->input('description');
        $location    = $request->input('location');
        $image       = $request->file('image');
        $owner_id    = 1;

        //check image upload

        if ($image) {

          $image_filename = $image->getClientOriginalName();
           $image->move(public_path('images'), $image_filename);
             DB::table($this->table)->where('id',$id)->update(

            [
             
             'title'       => $title,
             'description' => $description,
             'location'    => $location,
             'gallery_id'  => $gallery_id, 
             'image'       => $image_filename,
             'owner_id'    => $owner_id
            ]

        );

        } else {

             DB::table($this->table)->where('id',$id)->update(

            [
             'title'       => $title,
             'description' => $description,
             'location'    => $location,
             'gallery_id'  => $gallery_id, 
             'owner_id'    => $owner_id
            ]

            );
        }

    //Set Message

        \Session::flash('message','Portfolio Updated Successfully');

    //redirect

        //return \Redirect::route('photo.edit',array('id' => $id));
        return \Redirect::route('gallery.show',array('id' => $gallery_id));

    }
}
