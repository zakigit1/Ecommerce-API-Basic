<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'is_trendy',
        'is_available',
        'price',
        'amount',
        'discount',
        'image'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    protected $casts = [
        'is_trendy'=>'boolean',
        'is_available'=>'boolean'
    ];


    

    
    ################################ BEGIN RELATIONS #####################################
    public function category(){

        return $this->belongsTo(Category::class,'category_id','id','id');
    }

    public function brand(){

        return $this->belongsTo(Brand::class,'brand_id','id','id');
    }
    ################################ END RELATIONS #####################################

    ###################################GET##############################
    public function  getImageAttribute($val){
        return ($val !== null) ? asset('assets/images/products/' . $val) : "";
    }








}
