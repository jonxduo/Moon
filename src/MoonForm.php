<?php

namespace App;

use Former\Facades\Former;

class MoonForm
{
    public static function printFields ($fields)
    {
        foreach($fields as $field){
            echo MoonForm::getField($field);
        }
    }

    public static function getField ($data)
    {
        return MoonForm::{$data->field_type}($data);
    }

    public static function addStandardOptions ($field, $data)
    {
        if(isset($data->options->required) && $data->options->required == true) $field->required();
        if(isset($data->options->class)) $field->addClass($data->options->class);
        if(isset($data->options->groupClass)) $field->onGroupAddClass($data->options->groupClass);
        if(isset($data->options->placeholder)) $field->placeholder($data->options->placeholder);
        if(isset($data->options->data)) {
            foreach($data->options->data as $d=>$v){
                $field->{'data_'.$d}($v);
            }
        }
        if(isset($data->options->attributes)) $field->setAttributes($data->options->attributes);

        return $field;
    }

    public static function text ($data)
    {
        $field = Former::text($data->name)->label($data->label);
        return MoonForm::addStandardOptions($field, $data);
    }

    public static function textarea ($data)
    {
        $field = Former::textarea($data->name)->label($data->label);
        return MoonForm::addStandardOptions($field, $data);
    }

    public static function checkbox ($data)
    {
        $field = Former::checkbox($data->name)->label($data->label);
        return MoonForm::addStandardOptions($field, $data);
    }

    public static function radio ($data)
    {
        $field = Former::radio($data->name)->label($data->label);
        return MoonForm::addStandardOptions($field, $data);
    }

    public static function hidden ($data)
    {
        $field = Former::hidden($data->name)->label($data->label);
        return MoonForm::addStandardOptions($field, $data);
    }

    public static function select ($data)
    {
        $field = Former::select($data->name)->label($data->label);
        if ( isset($data->options->array) ) return MoonForm::array_select($field, $data);
        elseif ( isset($data->options->module) ) return MoonForm::module_select($field, $data);
    }

    public static function multiselect ($data)
    {
        $field = Former::multiselect($data->name)->label($data->label);
        if ( isset($data->options->array) ) return MoonForm::array_select($field, $data);
        elseif ( isset($data->options->module) ) return MoonForm::module_select($field, $data);
    }

    public static function array_select ($field, $data)
    {
        $field->options($data->options->array);
        return MoonForm::addStandardOptions($field, $data);
    }
}

?>
