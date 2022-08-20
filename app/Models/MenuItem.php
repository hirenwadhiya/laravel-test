<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $casts = [
        'parent_id' => 'array'
    ];

    public function parent(){
        return $this->hasMany(MenuItem::class,'id','parent_id');
    }

    public function children(){
        return $this->hasMany(MenuItem::class,'parent_id','id');
    }
}
