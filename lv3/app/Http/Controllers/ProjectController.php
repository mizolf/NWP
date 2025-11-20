<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('leader_id', auth()->id())
            ->orWhereHas('members', function ($q) {
            $q->where('users.id', auth()->id());
        })
            ->get();

    return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'tasks_done'  => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $data['leader_id'] = auth()->id();

        $project = Project::create($data);

        return redirect()->route('projects.show', $project);
    }
    public function addMember(Request $request, Project $project)
    {
        // samo voditelj može dodavati članove
        abort_unless(auth()->id() === $project->leader_id, 403);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // spriječi duplo dodavanje
        $project->members()->syncWithoutDetaching([$request->user_id]);

        return back();
    }

    /**
     * Display the specified resource.
     */
     public function show(Project $project)
    {
            // učitaj leadera i članove radi prikaza
        $project->load('leader', 'members');

        // svi korisnici osim voditelja (iz ovih ćeš birati člana)
        $users = User::where('id', '!=', $project->leader_id)->get();

        return view('projects.show', compact('project', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // opcionalno: dopusti edit samo voditelju i članovima
        abort_unless(
            auth()->id() === $project->leader_id ||
            $project->members->contains(auth()->id()),
            403
        );

        return view('projects.edit', compact('project'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        if (auth()->id() === $project->leader_id) {
            // voditelj – smije mijenjati sve
            $data = $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'price'       => 'required|numeric',
                'tasks_done'  => 'nullable|string',
                'start_date'  => 'required|date',
                'end_date'    => 'nullable|date|after_or_equal:start_date',
            ]);
        } else {
            // član tima – smije samo tasks_done
            abort_unless($project->members->contains(auth()->id()), 403);

            $data = $request->validate([
                'tasks_done' => 'required|string',
            ]);
        }

        $project->update($data);

        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
