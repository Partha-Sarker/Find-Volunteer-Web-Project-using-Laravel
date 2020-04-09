<?php

namespace App\Http\Controllers;

use App\Volunteer;
use Illuminate\Http\Request;
use Auth;
use Image;
use DB;
use App\Circular;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class VolunteerController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
        $this->middleware('checkSelf')->only('edit', 'update');
        $this->middleware('checkVolunteer')->only('sendJoinRequest');
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
            $volunteers = Volunteer::all()->paginateCollection(20);
        }
        else{
            $volunteers = Volunteer::query()->where('first_name', 'LIKE', "%{$searchItem}%")->orWhere('last_name', 'LIKE', "%{$searchItem}%")->get()->paginateCollection(20);
        }
        $volunteers->setPath('volunteer');
        $user = Auth::user();
        if($user == null || $user->role=='volunteer') return view('volunteer.index')->withvolunteers($volunteers);
        else{
            $organization = $user->Organization;
            $events = $organization->Event;
            $allVolunteers = Volunteer::all()->sortByDesc('rating')->take(5);
            return view('volunteer.index')->withvolunteers($volunteers)->withOrganization($organization)->withEvents($events)->withAllVolunteers($allVolunteers);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show(Volunteer $volunteer)
    {
        $events = DB::table('volunteers')->join('circular_volunteer', 'volunteers.id', '=', 'circular_volunteer.volunteer_id')
                        ->join('circulars', 'circulars.id', '=', 'circular_volunteer.circular_id')
                        ->join('events', 'events.id', '=', 'circulars.event_id')
                        ->select('events.*')->where('volunteers.id', $volunteer->id)->where('circular_volunteer.status','accepted')->distinct()->get();
        return view('volunteer.profile')->withVolunteer($volunteer)->withEvents($events);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        return view("volunteer.edit_profile")->withVolunteer($volunteer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Volunteer $volunteer)
    {
        //BUG::-- name not accepting '.'(dot)
        $request->validate([
            'first_name' => 'required|regex:/^[a-zA-Z._\s]+$/|max:20',
            'last_name' => 'required|regex:/^[a-zA-Z._\s]+$/|max:20',
            'gender' => 'required|Alpha',
            'date_of_birth' => 'required',
            'contact_number' => 'required|max:255',
            'address' => 'required|max:255',
            'profession' => 'required',
            'department' => 'max:100',
            'reg_no' => 'max:10'
        ]);
        //validate dept and reg_no if profession=student
        $volunteer->first_name = $request->input('first_name');
        $volunteer->last_name = $request->input('last_name');
        $volunteer->gender = $request->input('gender');
        $volunteer->date_of_birth = $request->input('date_of_birth');
        $volunteer->contact_number = $request->input('contact_number');
        $volunteer->address = $request->input('address');
        $volunteer->profession = $request->input('profession');
        $volunteer->department = $request->input('department');
        $volunteer->reg_no = $request->input('reg_no');
        $volunteer->save();
        if($request->hasFile('photo')){
            $photo = $request->file('photo');
            $filename = time().'.'.$photo->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($photo)->save($location);
            $user = $volunteer->User;
            $old_filename = $user->photo;
            $user->photo = $filename;
            if($old_filename != 'no_avatar.png'){
                Storage::delete($old_filename);
            }
            $user->save();
        }
        return redirect()->route('volunteer.show', $volunteer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volunteer $volunteer)
    {
        //
    }

    public function sendJoinRequest(Request $request, $circular_id){
        $volunteer_id = Auth::user()->Volunteer->id;
        $circular = Circular::find($circular_id);
        if($request->input('status') == 'pending'){
            $circular->volunteers()->attach($volunteer_id);
            DB::table('circular_volunteer')->where('circular_id', $circular_id)->where('volunteer_id', $volunteer_id)->update(['status' => 'pending']);
        }
        else if($request->input('status') == 'cancel request'){
            DB::table('circular_volunteer')->where('circular_id', $circular_id)->where('volunteer_id', $volunteer_id)->delete();
        }
        return redirect()->back();
    }

    
}
