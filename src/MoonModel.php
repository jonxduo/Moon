<?php

namespace Jxd\Moon;

use Illuminate\Database\Eloquent\Model;

class MoonModel extends Model
{
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }
}
