<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // if the user that makes the request is a the super admin then they can view all classrooms
        if(Auth::user()->hasRole('Super-Admin')) {
            return response()->json(Classroom::all());
        }
        // if the user that makes the request is a teacher or a student then they can only view the classrooms they are assigned to
        return response()->json(Auth::user()->classrooms);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:classrooms',
            'description' => 'required|string',
        ]);

        $classroom = new Classroom();
        $classroom->name = $request->name;
        $classroom->description = $request->description;
        // Set any other fields
        $classroom->save();

        // Attach the current user (assuming they're a teacher) to the classroom
        $classroom->users()->attach(Auth::id());

        return response()->json([
            'message' => 'Classroom created successfully',
            'classroom' => $classroom
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return response()->json($classroom);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        //
    }
}
