<?php

namespace App\Http\Controllers;

use App\Circular;
use Illuminate\Http\Request;
use App\Event;
use App\Volunteer;
use App\CircularVolunteer;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CircularController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('checkSelf')->except('show', 'join');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $event = Event::find($id);
        return view('circular.create')->withEvent($event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9._\s]+$/|max:50',
            'description' => 'required',
            'status' => 'required',
        ]);

        $circular=new Circular();
        $circular->name=$request->input('name');
        $circular->description=$request->input('description');
        $circular->status=$request->input('status');
        $circular->event_id=$id;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->save($location);
            $circular->image = $filename;
        }
        $circular->save();
        return redirect()->route('circular.show',[$id, $circular]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function show($id, Circular $circular)
    {
        $event = $circular->Event;
        $comments = $circular->Comment->sortByDesc('updated_at');
        // $comments->setPath($circular->id);
        $participants = $circular->Volunteers->sortByDesc('updated_at');
        return view('circular.show')->withCircular($circular)->withEvent($event)->withComments($comments)->withParticipants($participants);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Circular $circular)
    {
        $event = $circular->Event;
        return view('circular.edit')->withCircular($circular)->withEvent($event);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Circular $circular)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9._\s]+$/|max:50',
            'description' => 'required',
            'status' => 'required',
        ]);

        $circular->name=$request->input('name');
        $circular->description=$request->input('description');
        $circular->status=$request->input('status');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->save($location);
            $old_filename = $circular->image;
            $circular->image = $filename;
            if($old_filename != 'no_image.png') Storage::delete($old_filename);
        }
        $circular->save();
        return redirect()->route('circular.show',[$id, $circular]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Circular $circular)
    {
        $filename = $circular->image;
        $circular->delete();
        if($filename != 'no_image.png') Storage::delete($filename);
        return redirect()->route('event.show', $id);
    }

    public function validateJoinRequest(Request $request, $id, $circular_id, $volunteer_id)
    {
        $status = $request->input('status');
        if($status=='accepted'){
            DB::table('circular_volunteer')->where('circular_id', $circular_id)->where('volunteer_id', $volunteer_id)->update(['status' => 'accepted']);
        }
        else if($status=='rejected'){
            DB::table('circular_volunteer')->where('circular_id', $circular_id)->where('volunteer_id', $volunteer_id)->update(['status' => 'rejected']);
        }
        return redirect()->back();
    }
    
}
