<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $table = 'points';
    protected $fillable = ['user_id', 'point'];

    public function admin_user()
    {
        return $this->belongsTo(AdminUser::class,'user_id');
    }
}
