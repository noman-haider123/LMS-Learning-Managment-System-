<?php

namespace App\Http\Controllers;

use App\Models\JobPlacement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:job placement',only:['index'])
        ];
    }
    public function index()
    {
        $jobplacement = JobPlacement::all();
        return view('Student.job', compact('jobplacement'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'Position' => 'required',
            'image' => 'required'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_path = $file->store('Student_Profile', 'public');
            JobPlacement::create([
                'Student_Name' => $request->name,
                'Student_Review' => $request->description,
                'Student_Position' => $request->Position,
                'Student_Image' => $image_path
            ]);
        }
        return redirect()->route("jobindex")->with('success', "Placement added successfully");
    }
    public function edit(Request $request,$id){
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'position' => 'required',
            'image' => 'nullable'
        ]);
        if($validate->fails()){
            return back()->withErrors($validate)->withInput();
        }
        $jobPlacement = JobPlacement::findOrFail($id);
        if($request->hasFile('image')){
            if($jobPlacement->Student_Image && Storage::disk('public')->exists($jobPlacement->Student_Image)){
                Storage::disk('public')->delete($jobPlacement->Student_Image);
            }
            $file = $request->file('image');
            $imagepath = $file->store('Student_Profile','public');
        }
        else{
            $imagepath =  $jobPlacement->Student_Image;
        }
        $jobPlacement->update([
            'Student_Name' => $request->name,
            'Student_Review' => $request->description,
            'Student_Position' => $request->position,
            'Student_Image' => $imagepath,
        ]);
         return redirect()->route("jobindex")->with('success',"Placement updated successfully");
    }
    public function destroy($id){
          $JobPlacement = JobPlacement::findOrFail($id);
        if($JobPlacement->Student_Image && Storage::disk('public')->exists($JobPlacement->Student_Image)){
            Storage::disk('public')->delete($JobPlacement->Student_Image);
        }
        $JobPlacement->delete();
        return redirect()->route("jobindex")->with('error',"Placement deleted successfully");
    }
}