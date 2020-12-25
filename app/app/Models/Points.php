<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;

class Points extends Model
{
    protected $table = 'points';
    protected $fillable = ['user_id', 'point'];

    public function admin_user()
    {
        return $this->belongsTo(AdminUser::class,'user_id');
    }
    public function scopeGetFirst()
    {
        $points = Points::where('user_id',Admin::user()->id)->first();
        if(is_null($points)){
            $points->point = 0;
        }
        return $points->point;
    }
    public function scopeGetTotal()
    {
        $sum_points = Points::where('user_id',Admin::user()->id)->latest()->first();
        if(is_null($sum_points)){
            $sum_points->point = 0;
        }
        return $sum_points->point;
    }
}
