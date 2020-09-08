@extends('layouts.app')

@section('content')
<div class="container justify-center">
    <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
            <div class="dropdown">
                <!--Trigger-->
                <a class="btn btn-primary" data-toggle="dropdown">
                    Notifications @if($notifications->count() > 0)
                    <span class="iconbadge notifcounter">{{$notifications->count()}}</span> @endif
                </a>
                <!--Menu-->
                <div class="dropdown-menu dropdown-primary" id="your-custom-id">
                    @forelse($notifications as $notification)
                    <a class="dropdown-item mdb-dropdownLink-1" href="/readnotification/{{$notification->data['consultation_id']}}">
                        <h5>{{$notification->data['name']}} has a new report.</h5>
                        <p>{{$notification->created_at->diffForHumans()}}</p>
                    </a>
                    @empty
                    <p>No new notifications!</p>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-12 margin-tb">
                <br>
                <patientslist></patientslist>
            </div>
        </div>

    </div>
</div>
</div>

@endsection