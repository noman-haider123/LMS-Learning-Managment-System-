<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentAttendenceController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:Students Attendece', only: ['index'])
        ];
    }
    public function index()
    {
        // Check if today is Sunday and the user is NOT an admin
        if (Carbon::now()->isSunday() && !Auth::user()->hasRole('Admin')) {
            return redirect()->route('dashboard')->with('error', 'Attendance cannot be accessed on Sunday.');
        }

        $student = Student::orderBy('id','ASC');
        if (!Auth::user()->hasRole('Admin')) {
            $student->where('Created_By', Auth::id());
        }
        $students = $student->get();
        $users = User::role('Teacher');
         if (!Auth::user()->hasRole('Admin')) {
            $users->where('id', Auth::id());
        }
        $user = $users->get();
        $query = Attendence::with(['student', 'teacher'])
            ->orderBy('date', 'ASC');

        // Apply filter for non-admins only
        if (!Auth::user()->hasRole('Admin')) {
            $query->where('Created_By', Auth::id());
        }
        $Attendence = $query->get();

        return view('Student.StudentsAttendence', compact('students', 'user', 'Attendence'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Student' => 'required|exists:students,id',
            'Teacher' => 'required|exists:users,id',
            'TeacherEmail' => 'required|email|exists:users,email',
            'Date' => 'required|date',
            'StudentStatus' => 'required|in:Present,Absent,Late,Application Leave',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $existing = Attendence::where('student_id', $request->Student)
            ->where('date', $request->Date)
            ->first();

        if ($existing) {
            return redirect()->route("index")->with('error', 'Attendance for this student on this date already exists.')->withInput();
        }
        $Auth = Auth::id();
        $attendece = Attendence::create([
            'student_id' => $request->Student,
            'teacher_id' => $request->Teacher,
            'teacher_email_address' => $request->TeacherEmail,
            'date' => $request->Date,
            'status' => $request->StudentStatus,
            'Created_By' => $Auth,
        ]);
        if ($attendece) {
            return redirect()->route("index")->with('success', 'Attendance recorded successfully.');
        } else {
            return back()->with('error', 'Failed to record attendance. Please try again.');
        }
    }
    public function Update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'student_id' => 'required',
            'teacher_id' => 'required',
            'TeacherEmail' => 'required',
            'Date' => 'required|date',
            'StudentStatus' => 'required|in:Present,Absent,Late,Application Leave',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $attendece = Attendence::findOrFail($id);
        $Auth = Auth::id();
        $attendece->update([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'teacher_email_address' => $request->TeacherEmail,
            'date' => $request->Date,
            'status' => $request->StudentStatus,
            'Created_By' => $Auth,
        ]);
        return redirect()->route("index")->with('success', 'Attendance updated successfully.');
    }
    public function destroy($id)
    {
        $attendece = Attendence::findOrFail($id);
        $attendece->delete();
        return redirect()->route("index")->with('success', 'Attendance deleted successfully.');
    }
}
