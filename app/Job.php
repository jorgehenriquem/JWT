<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;

class Job extends Model
{
    protected $fillable = ['title', 'description', 'local', 'remote', 'type', 'company_id'];

    protected $dates = ['deleted_at'];

    function company() {
    	return $this->belongsTo('App\User');
    }
}
