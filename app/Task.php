<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
    protected $dates = ['due_date'];
    protected $fillable = ['title', 'description', 'due_date'];
}
