<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentCertificateController extends Controller implements HasMiddleware
{
  public static function middleware()
  {
    return [
      new Middleware('permission:delete certificate', only: ["destroy"])
    ];
  }
  public function index()
  {
    // Get students with user relation
    $query = Student::with("users");

    // If not Admin, show only students created by current user
    if (!Auth::user()->hasRole('Admin')) {
      $query->where('Created_By', Auth::id());
    }

    $students = $query->get();
    $course = Course::all();

    // Start building certificate query
    $certificateQuery = Certificate::with(['courses', 'students', 'users']);

    // Role-based filtering
    if (Auth::user()->hasRole('Admin')) {
      // Admin can see all certificates
      // no filtering
    } elseif (Auth::user()->hasRole('Teacher')) {
      // Teacher can see only the certificates they created
      $certificateQuery->where('Created_By', Auth::id());
    } elseif (Auth::user()->hasRole('Student')) {
      // Find the student linked to current user
      $student = Student::where('Name', Auth::user()->name)->first();

      if ($student) {
        // Student sees only their certificates
        $certificateQuery->where('Student_id', $student->id);
      } else {
        // No matching student found, return empty result
        $certificateQuery->whereRaw('1 = 0');
      }
    }

    $certificate = $certificateQuery->get();
    $pluck = Certificate::pluck("Student_id")->toArray();

    return view('Student.Certificate', compact('students', 'course', 'certificate', 'pluck'));
  }
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'Course_Name' => 'required',
      'Student_Name' => 'required',
      'Teacher_Name' => 'required'
    ]);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    Certificate::create([
      'Course_id' => $request->Course_Name,
      'Student_id' => $request->Student_Name,
      'Created_by' => $request->Teacher_Name
    ]);
    return redirect()->route("certificate")->with("success", "Certificate Added Successfully");
  }
  public function edit(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'Course_Name' => 'required',
      'Student_Name' => 'required',
      'Teacher_Name' => 'required'
    ]);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $certificate = Certificate::findOrFail($id);
    $certificate->update([
      'Course_id' => $request->Course_Name,
      'Student_id' => $request->Student_Name,
      'Created_by' => $request->Teacher_Name
    ]);
    return redirect()->route("certificate")->with("success", "Certificate Updated Successfully");
  }
  public function destroy($id)
  {
    $certificate = Certificate::findOrFail($id);
    $certificate->delete();
    return redirect()->route("certificate")->with("error", "Certificate Deleted Successfully");
  }
  public function download($id)
  {
    $certificate = Certificate::with(['students', 'courses', 'users'])->findOrFail($id);
    // dd($certificate->users);
    $pdf = Pdf::loadView('pdf', compact('certificate'));
    return $pdf->download('Certificate_' . $certificate->students->Name . '.pdf');
  }
}
