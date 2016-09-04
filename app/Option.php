<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = ['description', 'is_correct'];

    public function question() {
    	return $this->belongsTo('App\Question');
    }
}
