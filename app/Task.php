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

    public function scopeFilterCompleted($query, $completed = '')
    {
        if ($completed === "1" || $completed === 1 || $completed === true) {
            return $query->where('completed', true);
        } elseif ($completed === "0" || $completed === 0 || $completed === false) {
            return $query->where('completed', false);
        }

        return $query;
    }

    public function scopeFilterByDateField($query, $key, $value)
    {
        if (!$value) {
            return $query;
        }
        $date = new \DateTime($value);
        return $query->where($key, '>', $date);
    }
}
