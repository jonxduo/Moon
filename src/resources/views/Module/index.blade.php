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
                <table class="table">
                    <thead>
                        <tr>
                            @foreach($fields as $field)
                                <th>{{__($field->label)}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $resource)
                            <tr>
                                @foreach($fields as $field)
                                    <td>{{ $resource->{$field->name} }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
