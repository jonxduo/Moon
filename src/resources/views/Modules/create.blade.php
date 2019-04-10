@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>{{$title}}</h5>
              <div class="ibox-tools"> <span class="label label-warning-light pull-right">{{$action}}</span></div>
            </div>

            <div class="ibox-content">
                <?= Former::open(action($controllerName.'@store')); ?>
                    <?php App\MoonForm::printFields($fields); ?>
                    <?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset'); ?>
                <?= Former::close() ?>
            </div>
        </div>
    </div>
</div>
@endsection
