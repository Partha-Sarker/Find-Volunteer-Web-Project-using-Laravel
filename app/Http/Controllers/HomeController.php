<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Circular;
use App\CircularVolunteer;
use App\Organization;
use App\Volunteer;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $searchItem = Input::get('search');
        if($searchItem == null || $searchItem == ""){
            // $circulars = Circular::all()->sortByDesc('updated_at')->paginateCollection(5);
            $circulars = Circular::all()->sortByDesc('updated_at');
        // }
        }
        else{
            // $circulars = Circular::query()->where('name', 'LIKE', "%{$searchItem}%")->get()->paginateCollection(5);
            $circulars = Circular::query()->where('name', 'LIKE', "%{$searchItem}%")->get();
        // }
        }
        $volunteers = Volunteer::all()->sortByDesc('rating')->take(10);
        // $circulars->setPath('home');
        if($user = Auth::user()){
            if($user->role=='volunteer'){
                $volunteer = $user->Volunteer;
                return view('volunteer.home')->withVolunteer($volunteer)->withCirculars($circulars)->withVolunteers($volunteers);
            }
            else{
                $organization = $user->Organization;
                $events = $organization->Event->sortByDesc('updated_at')->take(5);
                $members = $organization->Member->sortBy('name');
                return view('organization.home')->withOrganization($organization)->withEvents($events)->withCirculars($circulars)->withMembers($members)->withVolunteers($volunteers);
            }
        }
        return view('home')->withCirculars($circulars);
    }

}
