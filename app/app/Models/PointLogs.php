<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class PointLogs extends Model
{
    protected $table = 'pointlogs';

    public function admin_user()
    {
        return $this->belongsTo(AdminUser::class,'user_id');
    }
    public function scopeGetTotal()
    {
        $sum_points = PointLogs::groupBy('user_id')->where('status','untreated')->selectRaw('sum(point) as sum, user_id')->pluck('sum')->first();
        if(is_null($sum_points)){
            $sum_points = 0;
        }
        return $sum_points;
    }
    // filter
    public function scopeGetFilter($query,?array $request)
    {
        if($request['id']!=''){
            $query->where('id','like', $request['id']);
        }

        if($request['created_at']['start']!=''){
            $query->where('created_at','>=',$request['created_at']['start']);
        }

        if($request['created_at']['end']!=''){
            $query->where('created_at','<=', $request['created_at']['end']);
        }

        return $query;
    }
}
