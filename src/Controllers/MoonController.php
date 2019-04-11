<?php

namespace Jxd\Moon\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jxd\Moon\Modules\Module;

class MoonController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth');
        $this->controllerName = str_replace('App\Http\Controllers', '', get_class($this));
        $this->moduleName = str_replace('Controller', '', (new \ReflectionClass($this))->getShortName());
        $module = Module::whereName($this->moduleName);
        if($module->count() > 0) $this->module = $module->first();
        else dd('ERROR MODULE NOT FOUND'); //TODO: prevedere azione

        // views parameters:
        $this->viewParams = array();
        $this->set([
            'controllerName' => $this->controllerName,
            'title' => $this->module->name,
            'description' => $this->module->description,
            'fields'=>$this->module->fields()->whereInTable(1)->get()
        ]);
        $this->set(['action'=>'list'], ['index']);
        $this->set(['action'=>'create'], ['create']);
        $this->set(['action'=>'edit'], ['edit']);
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
        return $this->render('index');
    }

    public function set ($params, $views = [])
    {
        if(count($views) == 0) $views = ['index', 'edit', 'create'];
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


}
