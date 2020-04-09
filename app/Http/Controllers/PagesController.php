<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('getEditProfile');
    }

    public function getEditProfile(){
        $user = Auth::user();
        if($user->role == 'volunteer')
            return redirect()->route('volunteer.edit', $user->Volunteer);
        else
            return redirect()->route('organization.edit', $user->Organization);
    }
    public function getHome(){
        return redirect()->route('home');
    }

    public function getContactUs(){
    	return view('pages.contact_us');
    }
    
    public function getChangePassword(){
        return view('change_password');
    }
}
