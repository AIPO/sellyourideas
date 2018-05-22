<?php

namespace App\Http\Controllers;

use App\Idea;
use Illuminate\Http\Request;
use App\Http\Resources\Idea as IdeaResource;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Ideas
        $ideas = Idea::orderBy('created_at','desc')->paginate(5);
        //return collection of ideas
        return IdeaResource::collection($ideas);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idea = $request->isMethod('put') ? Idea::findOrFail($request->id) : new Idea;
        $idea->id = $request->input('id');
        $idea->title = $request->input('title');
        $idea->body = $request->input('body');
        if($idea->save()){
            return new IdeaResource($idea);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     */
    public function show($id)
    {
        $idea = Idea::findOrFail($id);

        return new IdeaResource($idea);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idea = Idea::findOrFail($id);

        if($idea->delete()){
            return new IdeaResource($idea);
        }

    }
}
