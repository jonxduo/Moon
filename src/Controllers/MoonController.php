<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jxd\Moon\Modules\Module;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MoonController extends Controller
{
    public function __construct ()
    {
        $this->controllerName = str_replace('App\Http\Controllers\\', '', get_class($this));
        if($this->controllerName == 'MoonController') $this->setByRequest();
        else $this->setByChild();

        // views parameters:
        $this->viewParams = array();
        $this->set([
            'controllerName' => $this->controllerName,
            'moduleName' => $this->controllerName,
            'title' => $this->module->name,
            'description' => $this->module->description,
            'fields'=>$this->module->fields()->whereInTable(1)->get()
        ]);
        $this->set(['action'=>'list'], ['index']);
        $this->set(['action'=>'create'], ['create']);
        $this->set(['action'=>'edit'], ['edit']);
        $this->set(['action'=>'show'], ['show']);
        $this->set(['formUrl' => action($this->controllerName.'@store', ['module'=>$this->moduleName])], ['create']);
    }

    public function index ()
    {
        $this->set(['resources' => $this->module->model_name::all()], ['index']);
        return $this->render('index');
    }

    public function create ()
    {
        return $this->render('create');
    }

    public function store ()
    {
        $validator = Validator::make( Input::all(), [] );

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }else{
            $resource = new $this->module->model_name ;
            foreach( $this->module->fields()->get() as $field ){
                $resource->{$field->name} = Input::get($field->name);
            }
            $resource->save();
            Session::flash('message', __('Successfully created entity!'));
            return Redirect::to(action($this->controllerName.'@index', ['module' => $this->module->name]));
        }
    }

    public function show ($module, $id)
    {
        $this->set([
            'resource' => $this->module->model_name::find($id),
            'fields' => $this->module->fields()->get()
        ], ['show']);
        return $this->render('show');
    }

    public function edit ($module, $id)
    {
        $this->set([
            'resource' => $this->module->model_name::find($id),
            'formUrl' => action($this->controllerName.'@update', ['module'=>$this->moduleName, 'id'=>$id])
        ], ['edit']);
        return $this->render('edit');
    }

    public function update ($module, $id=null)
    {
        if($id == null) $id = Input::get('id');
        $validator = Validator::make( Input::all(), [] );

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }else{
            $model = new $this->module->model_name;
            $resource = $model->find($id);
            foreach( $this->module->fields()->get() as $field ){
                $resource->{$field->name} = Input::get($field->name);
            }
            $resource->save();
            Session::flash('message', __('Successfully update entity!'));
            return Redirect::to(action($this->controllerName.'@index', ['module' => $this->module->name]));
        }
    }

    public function destroy ($module, $id)
    {
        $this->module->model_name::destroy($id);
        Session::flash('message', __('Successfully delete entity!'));
        return Redirect::to(action($this->controllerName.'@index', ['module' => $this->module->name]));
    }

    public function build ($id)
    {
        //
    }

    public function upgrade ($id)
    {
        //
    }

    /** UTILITY */

    public function set ($params, $views = [])
    {
        if(count($views) == 0) $views = ['index', 'edit', 'create', 'show'];
        foreach($views as $v){
            if(isset($this->viewParams[$v])) $this->viewParams[$v] = array_merge($this->viewParams[$v], $params);
            else $this->viewParams[$v]=$params;
        }
    }

    public function getParams ($view){
        return $this->viewParams[$view];
    }

    public function render ($view)
    {
        $params = $this->getParams($view);
        $files = [
            $this->moduleName.'.'.$view,
            'Module.'.$this->moduleName.'.'.$view,
            'vendor.Moon.Module.'.$view
        ];
        return view()->first($files, $params)->render();
    }

    public function setByRequest(){
        $this->moduleName = request()->module;
        $module = Module::whereName($this->moduleName);
        if($module->count() == 0) return abort(404); //TODO prevedere azione
        else $this->module = $module->first();
    }

    public function setByChild(){
        $this->moduleName = str_replace('Controller', '', (new \ReflectionClass($this))->getShortName());
        $module = Module::whereName($this->moduleName);
        if($module->count() == 0) return abort(404); //TODO prevedere azione
        else $this->module = $module->first();
    }

}
