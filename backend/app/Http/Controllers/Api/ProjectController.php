<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // GET /api/projects
    public function index()
    {
        return Project::with('creator')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    // POST /api/projects
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:In Progress,Review,Completed',
            'due_date' => 'nullable|date',
            'questions' => 'nullable|array',
            'questions.*.text' => 'required|string',
            'questions.*.choices' => 'required|array|min:1',
            'questions.*.choices.*.choice_text' => 'required|string',
            'questions.*.choices.*.is_correct' => 'required|boolean',
        ]);

        $project = Project::create([
            ...$validated,
            'created_by' => $request->user()->id,
        ]);

        // Add questions + choices
        if (!empty($validated['questions'])) {
            foreach ($validated['questions'] as $q) {
                $question = $project->questions()->create([
                    'question_text' => $q['text'],
                ]);

                foreach ($q['choices'] as $c) {
                    $question->choices()->create([
                        'choice_text' => $c['choice_text'],
                        'is_correct' => $c['is_correct'],
                    ]);
                }
            }
        }

        return response()->json($project->load('questions.choices'), 201);
    }

}
