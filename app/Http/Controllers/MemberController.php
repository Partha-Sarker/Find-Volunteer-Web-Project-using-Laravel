<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('checkOrganization')->only('create', 'store');
        $this->middleware('checkSelf')->only('edit', 'update', 'destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create');
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
            'name' => 'required|regex:/^[a-zA-Z._\s]+$/|max:50',
            'designation' => 'required',
            'contact_number' => 'max:20',
            'address' => 'max:255',
        ]);
        $id = Auth::user()->Organization->id;
        $member=new Member();
        $member->name=$request->input('name');
        $member->designation=$request->input('designation');
        $member->joined_on=$request->input('joined_on');
        $member->contact_number=$request->input('contact_number');
        $member->email=$request->input('email');
        $member->address=$request->input('address');
        $member->organization_id=$id;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->save($location);
            $member->image = $filename;
        }
        $member->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $organization = $member->Organization;
        $members = $organization->Member;
        return view('member.show')->withMember($member)->withOrganization($organization)->withMembers($members);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $organization = $member->Organization;
        return view('member.edit')->withMember($member)->withOrganization($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z._\s]+$/|max:50',
            'designation' => 'required',
            'contact_number' => 'max:20',
            'address' => 'max:255',
        ]);
        
        $member->name=$request->input('name');
        $member->designation=$request->input('designation');
        $member->joined_on=$request->input('joined_on');
        $member->contact_number=$request->input('contact_number');
        $member->email=$request->input('email');
        $member->address=$request->input('address');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->save($location);
            $old_filename = $member->image;
            $member->image = $filename;
            if($old_filename != 'no_avatar.png') Storage::delete($old_filename);
        }
        $member->save();
        return redirect()->route('member.show', $member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $filename = $member->image;
        $member->delete();
        if($filename != 'no_avatar.png') Storage::delete($filename);
        return redirect()->route('home');
    }
}
