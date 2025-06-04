<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:Students Details', only: ['index'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Student::with('users')->orderBy("id", 'ASC');
        if (!Auth::user()->hasRole('Admin')) {
            $query->where('Created_By', Auth::id());
        }
        $students = $query->get();
        $allStudents = User::role("Student")->get(); // all students with 'Student' role
        $createdStudents = Student::pluck('name')->toArray(); // get already added student names

        $users = $allStudents->filter(function ($user) use ($createdStudents) {
            return !in_array($user->name, $createdStudents);
        });
        return view('Student.index', compact('students', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('Student.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'StudentName' => 'required|string|max:255',
            'StudentAddress' => 'required|string|max:255',
            'StudentClass' => 'required',
            'FatherMobileNumber' => 'required|numeric|min:11',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $Auth = Auth::id();
        $student = Student::create([
            'Name' => $request->StudentName,
            'Address' => $request->StudentAddress,
            'Class' => $request->StudentClass,
            'Father_Mobile_Number' => $request->FatherMobileNumber,
            'Created_By' => $Auth,
        ]);
        if ($student) {
            return to_route('students.index')->with('success', 'Student created successfully.');
        } else {
            return back()->with('error', 'Failed to create student.');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     // $student = Student::findOrFail($id);
    //     // return view('Student.index', compact('student'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        if ($student->delete()) {
            return to_route('students.index')->with('delete', 'Student deleted successfully.');
        } else {
            return back()->with('error', 'Failed to delete student.');
        }
    }
}
