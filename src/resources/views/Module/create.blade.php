@extends('vendor.Moon.layouts.app')

@section('content-title')
<b>{{$title}}</b> | {{$action}}
@endsection

@section('content-description')
{{$description}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
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
