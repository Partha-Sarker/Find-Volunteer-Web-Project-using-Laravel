<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\OrganizationVolunteer;
use App\Volunteer;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;


class OrganizationController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('show', 'index', 'showEvents');
        $this->middleware('checkOrganization')->only('rate');
        $this->middleware('checkSelf')->only('edit', 'update');
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
            $organizations = Organization::all()->paginateCollection(5);
        }
        else{
            $organizations = Organization::query()->where('name', 'LIKE', "%{$searchItem}%")->get()->paginateCollection(5);
        }
        $organizations->setPath('organization');
        $user = Auth::user();
        if($user == null) return view('organization.index')->withOrganizations($organizations);
        else if($user->role == 'volunteer'){
            $volunteers = Volunteer::all()->sortByDesc('rating')->take(10);
            return view('organization.index')->withOrganizations($organizations)->withVolunteers($volunteers);
        }
        else{
            $organization = $user->Organization;
            $events = $organization->Event;
            $volunteers = Volunteer::all()->sortByDesc('rating')->take(5);
            return view('organization.index')->withOrganizations($organizations)->withOrganization($organization)->withEvents($events)->withVolunteers($volunteers);
        }
    }

    public function showEvents($organization_id)
    {
        $organization = Organization::find($organization_id);
        $events = $organization->Event->paginateCollection(5);
        // $events->setPath('event');
        $volunteers = Volunteer::all();
        return view('organization.events')->withOrganization($organization)->withEvents($events)->withVolunteers($volunteers);
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
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $members = $organization->Member;
        $events = $organization->Event;
        return view('organization.profile')->withOrganization($organization)->withMembers($members)->withEvents($events);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        return view('organization.edit_profile')->withOrganization($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        //BUG::-- name not accepting '.'(dot)
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9._\s]+$/|max:20',
            'type' => 'required|Alpha',
            'founded_on' => 'required',
            'facebook' => 'max:255',
            'twitter' => 'max:255',
            'youtube' => 'max:255',
        ]);
        //validate dept and reg_no if profession=student
        $organization->name = $request->input('name');
        $organization->type = $request->input('type');
        $organization->description = $request->input('description');
        $organization->founded_on = $request->input('founded_on');
        $organization->facebook = $request->input('facebook');
        $organization->twitter = $request->input('twitter');
        $organization->youtube = $request->input('youtube');
        $organization->save();
        if($request->hasFile('photo')){
            $photo = $request->file('photo');
            $filename = time().'.'.$photo->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($photo)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);
            $user = $organization->User;
            $old_filename = $user->photo;
            $user->photo = $filename;
            if($old_filename != 'no_avatar.png'){
                Storage::delete($old_filename);
            }
            $user->save();
        }
        return redirect()->route('organization.show', $organization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */

    public function rate($volunteer_id, Request $request){
        $organization = Auth::user()->Organization;
        $volunteer = Volunteer::find($volunteer_id);
        $rating = $request->input('rating');
        $data = OrganizationVolunteer::where(['volunteer_id' => $volunteer_id,'organization_id' => $organization->id])->first();
        if($data==null){
            $organization->volunteers()->attach($volunteer_id);
            $newData = OrganizationVolunteer::where(['volunteer_id' => $volunteer_id,'organization_id' => $organization->id])->first();
            $newData['rating'] = $rating;
            $newData->save();
        }
        else{
            $data['rating'] = $rating;
            $data->save();
        }
        $count = 0;
        $sum = 0;
        foreach($volunteer->organizations as $organization){
            $sum += $organization->pivot->rating;
            $count++;
        }
        if($sum>0)
            $volunteer->rating = $sum/$count;
        else
            $volunteer->rating = 0;
        $volunteer->save();
        return redirect()->back();
    }

    public function destroy(Organization $organization)
    {
        //
    }

}
