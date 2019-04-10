<?php

namespace Jxd\Moon\Modules;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->appends[] = 'options';
    }

    public function model(){
        return $this->belongsTo('Jxd\Moon\Modules\Module', 'module_id');
    }

    public function setOptionsAttribute()
    {
        $this->attributes['options'] = \json_decode($this->json_options);
    }

    public function getOptionsAttribute()
    {
        return \json_decode($this->attributes['json_options']);
    }
}
