<?php

namespace App\Http\Controllers;

use App\EventPhoto;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;

class EventPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkSelf')->except('show', 'index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($event_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($event_id, Request $request)
    {
        if($request->hasFile('photo')){
            $event_photo = new EventPhoto();
            $photo = $request->file('photo');
            $filename = time().'.'.$photo->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($photo)->save($location);
            $event_photo->photo = $filename;
            $event_photo->event_id = $event_id;
            $event_photo->save();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventPhoto  $eventPhoto
     * @return \Illuminate\Http\Response
     */
    public function show($event_id, EventPhoto $eventPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventPhoto  $eventPhoto
     * @return \Illuminate\Http\Response
     */
    public function edit($event_id, EventPhoto $eventPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventPhoto  $eventPhoto
     * @return \Illuminate\Http\Response
     */
    public function update($event_id, Request $request, EventPhoto $eventPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventPhoto  $eventPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy($event_id, EventPhoto $eventPhoto)
    {
        $filename = $eventPhoto->photo;;
        $eventPhoto->delete();
        Storage::delete($filename);
        return redirect()->back();
    }
}
