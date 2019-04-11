<?php

namespace Jxd\Moon\Modules;

use Jxd\Moon\MoonModel;

class Module extends MoonModel
{
    //use SoftDeletes;

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
