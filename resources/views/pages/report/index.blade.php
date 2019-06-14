@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="app">
            <report admin="{{json_encode($admin)}}"></report>


        </div>
    </div>


@endsection
