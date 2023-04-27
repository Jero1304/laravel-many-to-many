<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::withTrashed()->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::orderBy('name', 'asc')->get();

        $technologies = Technology::orderBy('name','asc')->get();
        return view('projects.create', compact('types','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title']);

        $project = Project::create($data);

        if(isset($data['technologies'])){
            $project->technologies()->attach($data['technologies']);
        }

        return to_route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::orderBy('name','asc')->get();
        $technologies = Technology::orderBy('name','asc')->get();

        return view('projects.edit', compact('project','types','technologies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($data['title'] !== $project->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        $project->update($data);
        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        } else{
            $project->technologies()->sync([]);
        }

        return to_route('projects.show', $project);

    }

    public function restore(Project $project)
    {
        if ($project->trashed()) {
            $project->restore();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->trashed()) {

            // $project->technologies()->detach();

            $project->forceDelete();
        } else {
            $project->delete();
        }

        return to_route('projects.index');
    }
}