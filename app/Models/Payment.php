<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'Customer_Name',
        'Amount',
        'Currency',
        'description',
        'Course_Id',
        'Customer_Email',
        'Country',
        'City'
    ];
    public function courses(){
        return $this->belongsTo(Course::class,'Course_Id');
    }
}
