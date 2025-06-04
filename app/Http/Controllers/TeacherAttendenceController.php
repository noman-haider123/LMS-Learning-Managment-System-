<?php

namespace App\Http\Controllers;

use App\Models\TeacherAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TeacherAttendenceController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:Check In', only: ['checkIn']),
            new Middleware('permission:Check Out', only: ['checkOut']),
            new Middleware('permission:Teacher Attendence', only: ['index']),
        ];
    }
    public function checkIn(Request $request)
    {
        if (Carbon::now()->isSunday()) {
            return redirect()->back()->with('error', 'Check-in is not allowed on Sunday.');
        }
        // if (Carbon::now()->hour < 7 || Carbon::now()->hour > 14) { // Fixed: 2 PM is hour 14
        //     return redirect()->back()->with('error', 'Check-in is only allowed between 7 AM and 2 PM.');
        // }
        $today = Carbon::now()->timezone('Asia/Karachi')->toDateString(); // Adjust timezone as needed
        $existingAttendance = TeacherAttendance::where('teacher_id', Auth::id())
            ->whereDate('check_in_time', $today)
            ->first();
        if ($existingAttendance) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }
        $ip = $request->ip();
        // Call IP location API
        $response = Http::get("http://ip-api.com/json")->json();
        // Check if response is successful
        if ($response['status'] !== 'success') {
            return redirect()->back()->with('error', 'Unable to determine location. Try again.');
        }
        // $schooollatitude =  24.9434;  // AL-Jauhar Grammar School
        // $schooollongitude = 67.2059;
        $schooollatitude = 24.8591000; // My School
        $schooollongitude = 66.9983000;
        if (abs($response['lat'] - $schooollatitude) > 0.0001 || abs($response['lon'] - $schooollongitude) > 0.0001) {
            return redirect()->back()->with('error', 'You must be at the exact school location to check in.');
        }
        $latitude = $response['lat'];
        $longitude = $response['lon'];
        $location = $response['city'] . ', ' . $response['country'];
        // Save attendance to database
        TeacherAttendance::create([
            'teacher_id' => Auth::id(),
            'ip_address' => $ip,
            'location' => $location,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'check_in_time' => Carbon::now()->timezone('Asia/Karachi')->toDateTimeString(), // Adjust timezone as needed
        ]);
        return redirect()->route("dashboard")->with('message', 'Check-in recorded!');
    }
    public function checkOut(Request $request)
    {
        if (Carbon::now()->isSunday()) {
            return redirect()->back()->with('error', 'Check-out is not allowed on Sunday.');
        }
        // if (Carbon::now()->hour < 7 || Carbon::now()->hour > 14) { // Fixed: 2 PM is hour 14
        //     return redirect()->back()->with('error', 'Check-out is only allowed between 7 AM and 2 PM.');
        // }
        $today = Carbon::now()->timezone('Asia/Karachi')->toDateString(); // Adjust timezone as needed
        $existingAttendance = TeacherAttendance::where('teacher_id', Auth::id())
            ->whereDate('check_in_time', $today)
            ->first();
        if (!$existingAttendance) {
            return redirect()->back()->with('error', 'You have not checked in today.');
        }
        $response = Http::get("http://ip-api.com/json")->json();
        // $schooollatitude =  24.9434;  // AL-Jauhar Grammar School
        // $schooollongitude = 67.2059;
        $schooollatitude = 24.8591000; // My School
        $schooollongitude = 66.9983000;
        if (abs($response['lat'] - $schooollatitude) > 0.0001 || abs($response['lon'] - $schooollongitude) > 0.0001) {
            return redirect()->back()->with('error', 'You must be at the exact school location to check out.');
        }
        // Check if the teacher has already checked out
        if ($existingAttendance->check_out_time) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }
        $attendance = TeacherAttendance::where('teacher_id', Auth::id())
            ->whereNull('check_out_time')
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'You have not checked in yet.');
        }

        $attendance->check_out_time = Carbon::now()->timezone('Asia/Karachi')->toDateTimeString();
        $attendance->save();
        return redirect()->route("dashboard")->with('message', 'Check-out recorded!');
    }
    public function index(){
        $attendances  = TeacherAttendance::with('users')->latest()->get();
        return view('Student.TeacherAttendence', compact('attendances'));
    }
}
