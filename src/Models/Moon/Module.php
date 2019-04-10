<?php

namespace App\Moon;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->appends[] = 'fields';
    }

    public function fields()
    {
        return $this->hasMany('App\Moon\Field', 'module_id');
    }

    public function setFieldsAttribute()
    {
        $this->attributes['fields'] = $this->fields()->get();
    }

    public function getFieldsAttribute()
    {
        return $this->fields()->get();
    }
}
