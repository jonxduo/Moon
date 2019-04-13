<?php

namespace Jxd\Moon;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Jxd\Moon\Modules\Module;

class Builder
{
    public function __construct($module)
    {
        $this->module = $module;
        $this->templateDir = __DIR__ . '/stubs';
    }

    public function building ()
    {
        $controllerFile = $this->buildController();
        $migrationFile = $this->buildMigration();
        $moduleFile = $this->buildModel();
        //$this->buildRoutes();
    }

    public function buildController()
    {
        $stub = file_get_contents($this->templateDir . "/controller.stub");

        $stub = str_replace('__model_name__', $this->module->model_name, $stub);
        $stub = str_replace('__controller_class_name__', $this->controllerClassName(), $stub);
        $stub = str_replace('__module__', $this->module->name, $stub);
        $stub = str_replace('__name__', $this->module->name, $stub);

        $filename = $this->controllerClassName() . ".php";
        file_put_contents(base_path('app/Http/Controllers/Modules/' . $filename), $stub);
        return $filename;
    }

    public function buildMigration()
    {
        $stub = file_get_contents($this->templateDir . "/createMigration.stub");

        $stub = str_replace('__migration_class_name__', $this->migrationClassName(), $stub);
        $stub = str_replace('__db_table_name__', strtolower(Str::plural($this->module->name)), $stub);
        $stub = str_replace('__generated_table_fields__', $this->tableFields(), $stub);

        $filename = $this->migrationFileName() . ".php";
        file_put_contents(base_path('database/migrations/' . $filename), $stub);
        Artisan::call('migrate', array('--path' => 'database/migrations/'.$filename));
        return $filename;
    }

    public function buildModel()
    {
        $stub = file_get_contents($this->templateDir . "/model.stub");

        $stub = str_replace('__model_class_name__', $this->modelClassName(), $stub);
        $stub = str_replace('__generated_appends__', $this->modelAppends(), $stub);
        $stub = str_replace('__generated_relation_functions__', $this->modelRelations(), $stub);

        $filename = $this->modelClassName() . ".php";
        file_put_contents(base_path('app/Modules/' . $filename), $stub);
        return $filename;
    }

    public static function build ($module)
    {
        $builder = new Builder($module);
        return $builder->building();
    }

    /** UTILITY */
    public function controllerClassName()
    {
        return ucfirst($this->module->name).'Controller';
    }

    public function migrationClassName()
    {
        $name = ucfirst(Str::plural($this->module->name));
        return 'Create'.$name.'Table';
    }

    public function modelClassName()
    {
        return ucfirst($this->module->name);
    }

    public function migrationFileName()
    {
        $name = Str::plural($this->module->name);
        return date('Y_m_d_His_').'create_'.$name.'_table';
    }

    public function tableFields()
    {
        $out = '';
        foreach($this->module->fields as $field){
            $out .= "           \$table->".$field->type."('".$field->name."'";
            if(isset($field->options->length)) $out .= ", ".$field->options->length;
            if(isset($field->options->decimal)) $out .= ", ".$field->options->decimal;
            $out .= ")";
            if(!isset($field->options->required) || $field->options->required == false) $out .= "->nullable()";
            if(isset($field->options->default)) $out .= "->default('".$field->options->default."')";
            if(isset($field->options->unique)) $out .= "->unique()";
            $out .= ";\n";
        }

        return $out;
    }

    public function modelAppends()
    {
        $fields = $this->module->fields()->whereRelation(true)->get();
        $out = '';
        foreach($fields as $field){
            $out .= "        \$this->appends[] = '".strtolower($field->options->module)."';\n";
        }

        return $out;
    }

    public function modelRelations()
    {
        $fields = $this->module->fields()->whereRelation(true)->get();
        $out = '';
        foreach($fields as $field){
            $module = Module::whereName($field->options->module)->first();
            $tmpOut = file_get_contents($this->templateDir . "/belongsto.stub");
            $tmpOut = str_replace('__relation_name__', strtolower($field->options->module), $tmpOut);
            $tmpOut = str_replace('__relation_name_u__', ucfirst($field->options->module), $tmpOut);
            $tmpOut = str_replace('__model_name__', $module->model_name, $tmpOut);
            $tmpOut = str_replace('__foreign_key__', $field->name, $tmpOut);
            $out .= $tmpOut;
        }

        return $out;
    }
}
