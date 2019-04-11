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
                <dl>
                    @foreach($fields as $field)
                        <dt>{{__($field->label)}}</dt>
                        <dd>{{ $resource->{$field->name} }}</dd>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
