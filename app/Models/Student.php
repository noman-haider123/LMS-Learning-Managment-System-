<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'Name',
        'Address',
        'Class',
        'Father_Mobile_Number',
        'Created_By'
    ];
    protected $table = 'students';
    protected $primaryKey = 'id';
    public function users(){
        return $this->belongsTo(User::class,'Created_By');
    }
}
