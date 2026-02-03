<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    // GET /api/projects/{project}/choices
    public function index(Project $project)
    {
        return $project->choices()
            ->orderBy('created_at', 'asc')
            ->get();
    }

    // POST /api/projects/{project}/choices
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'choice_text' => 'required|string|max:255',
            'is_correct' => 'nullable|boolean',
        ]);

        // Ensure only one correct choice per project
        if (!empty($validated['is_correct']) && $validated['is_correct']) {
            $project->choices()->update(['is_correct' => false]);
        }

        $choice = $project->choices()->create($validated);

        return response()->json($choice, 201);
    }
}
