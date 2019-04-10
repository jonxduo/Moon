<?php
namespace Jxd\Moon;

use Illuminate\Database\Seeder;
use Jxd\Moon\Modules\Module;
use Jxd\Moon\Modules\Field;

class MoonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Module in Module table
        $module = new Module;
        $module->name = 'Module';
        $module->model_name = 'Jxd\Moon\Modules\Module';
        $module->description = 'Module managament';
        $module->active = true;
        $module->builded = true;
        $module->updated = true;
        $module->save();
        // Module fields in field table
        $field = new Field;
        $field->module_id = $module->id;
        $field->name = 'name';
        $field->label = 'Name';
        $field->type = 'string';
        $field->field_type = 'text';
        $field->json_options = '{"required":"true"}';
        $field->in_table = true;
        $field->save();
        $field = new Field;
        $field->module_id = $module->id;
        $field->name = 'model_name';
        $field->label = 'Model Name';
        $field->type = 'string';
        $field->field_type = 'text';
        $field->json_options = '{"required":"true"}';
        $field->in_table = true;
        $field->save();
        $field = new Field;
        $field->module_id = $module->id;
        $field->name = 'description';
        $field->label = 'Description';
        $field->type = 'string';
        $field->field_type = 'textarea';
        $field->json_options = '{"required":"true"}';
        $field->in_table = true;
        $field->save();
        // Field in Module table
        $module = new Module;
        $module->name = 'Field';
        $module->model_name = 'Jxd\Moon\Modules\Field';
        $module->description = 'Fields managament';
        $module->active = true;
        $module->builded = true;
        $module->updated = true;
        $module->save();
    }
}
