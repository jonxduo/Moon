@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>{{$title}}</h5>
              <div class="ibox-tools"> <span class="label label-warning-light pull-right">{{$action}}</span></div>
            </div>

            <div class="ibox-content">
                <table class="table">
                    <thead>
                        <tr>
                            @foreach($fields as $field)
                                <th>{{$field->label}}</th>
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
