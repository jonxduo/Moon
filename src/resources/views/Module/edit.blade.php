@extends('vendor.Moon.layouts.app')

@section('content-title')
<b>{{__($title)}}</b>: {{__($action)}}
@endsection

@section('content-description')
{{__($description)}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?= Former::open($formUrl)->method('PUT');?>
                    <?php Former::populate($resource); ?>
                    <?php Jxd\Moon\MoonForm::printFields($fields); ?>
                    <?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset'); ?>
                <?= Former::close() ?>
            </div>
        </div>
    </div>
</div>
@endsection
