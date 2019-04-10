<?php

namespace App\Moon;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->appends[] = 'options';
    }

    public function model(){
        return $this->belongsTo('App\Moon\Module', 'module_id');
    }

    public function setOptionsAttribute()
    {
        $this->attributes['options'] = \json_decode($this->options);
    }

    public function getOptionsAttribute()
    {
        return \json_decode($this->attributes['options']);
    }
}
