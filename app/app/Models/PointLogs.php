<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLogs extends Model
{
    protected $table = 'pointlogs';

    public function admin_user()
    {
        return $this->belongsTo(AdminUser::class,'user_id');
    }
}
