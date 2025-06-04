<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\JobPlacement;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return[
            new Middleware("permission:courses Details",only:['index'])
        ];
    }

    public function index()
    {
        $courses = Course::all();
        return view('Student.Course', compact('courses'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Course' => 'required|string',
            'CourseDescription' => 'required|string',
            'CoursePrice' => 'required',
            'Image' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');

            $path = $file->store('courses', 'public');

            Course::create([
                'Course_Name' => $request->Course,
                'Course_Description' => $request->CourseDescription,
                'Price' => $request->CoursePrice,
                'Course_Image' => $path,
            ]);
            return redirect()->route("course")->with('success', 'Course created successfully');
        } else {
            return redirect()->back()->with('error', 'Image upload failed');
        }
    }
    public function edit(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'Course' => 'required|string',
            'Description' => 'required|string',
            'Price' => 'required',
            'Image' => 'nullable',
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $course = Course::findOrFail($id);

        if ($request->hasFile('Image')) {
            // Delete old image if it exists
            if ($course->Course_Image && Storage::disk('public')->exists($course->Course_Image)) {
                Storage::disk('public')->delete($course->Course_Image);
            }
            // Store new image
            $imagePath = $request->file('Image')->store('courses', 'public');
        } else {
            $imagePath = $course->Course_Image; // Keep old image
        }
        // Update course
        $course->update([
            'Course_Name' => $request->Course,
            'Course_Description' => $request->Description,
            'Price' => $request->Price,
            'Course_Image' => $imagePath,
        ]);
        return redirect()->route("course")->with('success', 'Course updated successfully');
    }
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->Course_Image && Storage::disk('public')->exists($course->Course_Image)) {
            Storage::disk('public')->delete($course->Course_Image);
        }
        $course->delete();
        return redirect()->route("course")->with('success', 'Course deleted successfully');
    }
    public function showcourse(){
        $course = Course::all();
        $why_choose_us = WhyChooseUs::all();
        $JobPlacement = JobPlacement::all();
        $stripekey = config('services.stripe.key');
        return view("welcome",compact('course','JobPlacement','why_choose_us','stripekey'));
    }
}
