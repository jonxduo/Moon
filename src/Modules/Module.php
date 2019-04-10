<?php

namespace Jxd\Moon\Modules;

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
        return $this->hasMany('Jxd\Moon\Modules\Field', 'module_id');
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
