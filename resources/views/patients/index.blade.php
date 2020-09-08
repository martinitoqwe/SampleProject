@extends('layouts.app')

@section('content')
<div class="container justify-center">
    <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
            <div class="info">
                <h1 class="display-4">Patient Information</h1>
                <strong>Name: </strong>{{auth()->user()->lastname .', '.auth()->user()->firstname }}<br>
                <strong>Birthday: </strong> {{auth()->user()->patient->birthday}}<br>
                <strong>Phone: </strong> {{auth()->user()->patient->phone}}<br>
                <strong>Address: </strong> {{auth()->user()->patient->address}}
                <strong>City: </strong>{{auth()->user()->patient->city}}
                <strong> State: </strong>{{auth()->user()->patient->state}}
                <strong>Zip: </strong> {{auth()->user()->patient->zip}}<br>
                <hr>
            </div>
            <Userreport></Userreport>
        </div>

    </div>
</div>
</div>
@endsection