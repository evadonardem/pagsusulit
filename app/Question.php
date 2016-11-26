<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['description', 'is_random_options', 'is_finalized'];

    public function options() {
    	return $this->hasMany('App\Option');
    }
}
