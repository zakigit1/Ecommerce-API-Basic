<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table ='locations';

    protected $fillable=[
        'user_id',
        'street',
        'area',
        'building'
    ];


    protected $hidden =[
        'created_at',
        'updated_at'
    ];



    public function user(){
        return $this->belongsTo(User::class,'user_id','id','id');
    }
}
