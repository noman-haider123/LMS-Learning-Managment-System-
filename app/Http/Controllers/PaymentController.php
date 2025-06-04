<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return[
            new Middleware('permission:course Enrollment payment',only:['index'])
        ];
    }
    public function checkout(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'Country' => 'required',
            'City' => 'required'
        ]);
        if($validate->fails()){
            return back()->withErrors($validate)->withInput();
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));

        Charge::create([
            "amount" => $request->amount * 100, 
            "currency" => "PKR",
            "source" => $request->stripeToken,
             "metadata" => [
               "name" => $request->name,
               "email" => $request->email,
               'country' => $request->Country,
               'city' => $request->City
             ],
            "description" => "Course Enrollment Advance Payment"
        ]);
        Payment::create([
            'Course_Id' => $request->course_id,
            'Customer_Name' => $request->name,
            'Customer_Email' => $request->email,
            'Country' => $request->Country,
            'City' => $request->City,
            'Amount' => $request->amount * 100,
            "Currency" => "PKR",
            "description" => "Course Enrollment Advance Payment"
        ]);
         return redirect('/')->with('success', 'Payment successful! For more info, contact: nomaniqbalhaider@gmail.com');
    }
    public function index(){
        $payements = Payment::with('courses')->get();
        return view('Student.fetchpayment',compact('payements'));
    }
}
