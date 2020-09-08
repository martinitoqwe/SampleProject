@extends('layouts.app')

@section('content')
<div class="container justify-center">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
    	<h3 class="text-center">
    		{{Auth::user()->pharmacy->pharmacy_name}}</h3>
        <prescriptionlist> </prescriptionlist>
        </div>
    </div>
</div>
@endsection