<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Circular;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkSelf')->only('edit', 'update', 'destroy');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        
        if($request->input('comment')==''){
            // return redirect()->back()->with('error', 'Comment field can not be empty');
            return redirect()->back();
        }
            
        $user = Auth::user();
        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->circular_id = $id;
        $comment->user_id = $user->id;
        $comment->save();
        $circular = Circular::find($id);
        $circular->updated_at=Carbon::now();
        $circular->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id, Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Comment $comment)
    {
        $circular = Circular::find($id);
        return view('comment.edit')->withComment($comment)->withCircular($circular);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Comment $comment)
    {
        $comment->comment = $request->input('comment');
        $comment->save();
        $circular = Circular::find($id);
        $circular->updated_at=Carbon::now();
        $circular->save();
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
