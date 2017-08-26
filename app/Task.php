<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
    protected $dates = ['due_date'];
    protected $fillable = ['title', 'description', 'due_date', 'completed'];

    public function setCompletedAttribute($value)
    {
        if (strtolower($value) == 'true' || (int) $value == 1) {
            $this->attributes['completed'] = true;
        } else {
            $this->attributes['completed'] = false;
        }
    }
}
