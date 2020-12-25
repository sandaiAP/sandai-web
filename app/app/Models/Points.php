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
        $p = $points->point;
        if(is_null($p)){
            $p = 0;
        }
        return $p;
    }
    public function scopeGetTotal()
    {
        $sum_points = Points::where('user_id',Admin::user()->id)->latest()->first();
        $p = $sum_points->point;
        if(is_null($p)){
            $p = 0;
        }
        return $p;
    }
}
