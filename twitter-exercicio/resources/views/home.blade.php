@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>


    <form method="post" action="{{ route('saveMessage') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Type a message" aria-label="Type a message" aria-describedby="basic-addon2" name="message">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Button</button>
            </div>
        </div>
    </form>

</div>
@endsection
