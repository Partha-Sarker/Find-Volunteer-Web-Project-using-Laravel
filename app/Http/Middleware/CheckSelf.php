<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Circular;

class CheckSelf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(class_basename($request->route()->controller) == "EventController"){
            if($request['event']->Organization->user_id != $request->user()->id){
                return redirect()->back();
            }
        }
        else if(class_basename($request->route()->controller) == "MemberController"){
            if($request['member']->Organization->user_id != $request->user()->id){
                return redirect()->back();
            }
        }
        else if(class_basename($request->route()->controller) == "OrganizationController"){
            if($request['organization']->User->id != $request->user()->id){
                return redirect()->back();
            }
        }
        else if(class_basename($request->route()->controller) == "CircularController"){
            if(Event::find($request['id'])->Organization->user_id != $request->user()->id){
                return redirect()->back();
            }
        }
        else if(class_basename($request->route()->controller) == "VolunteerController"){
            if($request['volunteer']->User->id != $request->user()->id){
                return redirect()->back();
            }
        }
        else if(class_basename($request->route()->controller) == "EventPhotoController"){
            if(Event::find($request['event_id'])->Organization->user_id != $request->user()->id){
                return redirect()->back();
            }
        }
        else if(class_basename($request->route()->controller) == "CommentController"){
            if($request->route()->methods[0] == "DELETE"){
                $circular_parent = Circular::find($request['id'])->Event->Organization->user_id;
                if($circular_parent == $request->user()->id){
                    // dd($request->route()->controller);
                    return $next($request);
                }
            }
            if($request['comment']->User->id == $request->user()->id){
                // dd($request->route()->controller);
                return $next($request);
            }
            return redirect()->back();
        }

        // dd($request->route()->controller);
        return $next($request);
    }
}
