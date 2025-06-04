<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'Course_Name',
        'Course_Description',
        'Course_Image',
        'Price',
    ];
}
