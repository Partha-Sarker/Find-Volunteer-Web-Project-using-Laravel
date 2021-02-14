<?php

namespace App\Http\Controllers;

use App\Event;
use App\Circular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\Storage;
use App\EventPhoto;
use App\Volunteer;
use App\Organization;
use Illuminate\Support\Facades\Input;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
        $this->middleware('checkSelf')->only('edit', 'update', 'destroy');
        $this->middleware('checkOrganization')->only('create', 'store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchItem = Input::get('search');
        if($searchItem == null || $searchItem == ""){
            $events = Event::all();
        }
        else{
            $events = Event::query()->where('name', 'LIKE', "%{$searchItem}%")->get();
        }
        // $events->setPath('event');
        $user = Auth::user();
        if($user == null) return view('event.index')->withevents($events);
        else if($user->role == 'volunteer'){
            $volunteers = Volunteer::all()->sortByDesc('rating')->take(10);
            return view('event.index')->withVolunteers($volunteers)->withEvents($events);
        }
        else{
            $organization = $user->Organization;
            $volunteers = Volunteer::all()->sortByDesc('rating')->take(5);
            $myEvents = $organization->Event;
            return view('event.index')->withevents($events)->withMyEvents($myEvents)->withOrganization($organization)->withVolunteers($volunteers);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9._\s]+$/|max:50',
            'description' => 'required',
            'type' => 'required|Alpha',
            'status' => 'required',
        ]);
        $id = Auth::user()->Organization->id;
        $event=new Event();
        $event->name=$request->input('name');
        $event->description=$request->input('description');
        $event->type=$request->input('type');
        $event->status=$request->input('status');
        $event->start_time=$request->input('start_time');
        $event->end_time=$request->input('end_time');
        $event->organization_id=$id;
        if($request->hasFile('default_image')){
            $default_image = $request->file('default_image');
            $filename = time().'.'.$default_image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($default_image)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);
            $event->default_image = $filename;
        }
        $event->save();
        return redirect()->route('event.show',$event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $circulars = $event->Circular;
        $photos = $event->EventPhoto;
        $organization = $event->Organization;
        return view('event.show')->withEvent($event)->withCirculars($circulars)->withPhotos($photos)->withOrganization($organization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('event.edit')->withEvent($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        // if($request->user()->id != $event->User->id) return redirect()->back();
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9._\s]+$/|max:50',
            'description' => 'required',
            'type' => 'required|Alpha',
            'status' => 'required',
        ]);
        $event->name=$request->input('name');
        $event->description=$request->input('description');
        $event->type=$request->input('type');
        $event->status=$request->input('status');
        $event->start_time=$request->input('start_time');
        $event->end_time=$request->input('end_time');
        if($request->hasFile('default_image')){
            $default_image = $request->file('default_image');
            $filename = time().'.'.$default_image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($default_image)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);
            $old_filename = $event->default_image;
            $event->default_image = $filename;
            if($old_filename != 'no_image.png') Storage::delete($old_filename);
        }
        $event->save();
        return redirect()->route('event.show',$event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $filename = $event->default_image;
        $event->delete();
        if($filename != 'no_image.png') Storage::delete($filename);
        return redirect()->route('home');
    }
}
