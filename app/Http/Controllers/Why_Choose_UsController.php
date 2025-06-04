<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\TeacherAttendance;
use App\Models\User;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Why_Choose_UsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:About us', only: ['index'])
        ];
    }
    public function index()
    {
        $Why_Choose_us = WhyChooseUs::all();
        return view('Student.why_choose_us', compact("Why_Choose_us"));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->store('Why_Choose_us', 'public');
            WhyChooseUs::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $filename
            ]);
        }
        return redirect()->route("whychooseme")->with('success', "About us added successfully");
    }
    public function edit(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $why_choose_us = WhyChooseUs::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($why_choose_us->image && Storage::disk('public')->exists($why_choose_us->image)) {
                Storage::disk('public')->delete($why_choose_us->image);
            }
            $file = $request->file('image');
            $image_path = $file->store('Why_Choose_us', 'public');
        } else {
            $image_path = $why_choose_us->image;
        }
        $why_choose_us->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_path
        ]);
        return redirect()->route("whychooseme")->with('success', "About us updated successfully");
    }
    public function destroy($id)
    {
        $whychooseus = WhyChooseUs::findOrFail($id);
        if ($whychooseus->image && Storage::disk('public')->exists($whychooseus->image)) {
            Storage::disk('public')->delete($whychooseus->image);
        }
        $whychooseus->delete();
        return redirect()->route("whychooseme")->with('error', "About_us deleted successfully");
    }
    public function dashboard()
    {
        $userCount = User::count();
        $query = Student::orderBy('id', 'ASC');
        if (!Auth::user()->hasRole('Admin')) {
            $query->where('Created_By', Auth::id());
        }
        $students = $query->count();
        $courseCount = Course::count();
        $teacherAttendanceCount = TeacherAttendance::count();
        return view('Student.dashboard',compact('userCount','students','courseCount','teacherAttendanceCount'));
    }
}
