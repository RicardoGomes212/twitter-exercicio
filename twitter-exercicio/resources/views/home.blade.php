@extends('layouts.app')

@section('content')

    <form method="post" action="{{ route('saveMessage') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Type a message" aria-label="Type a message" aria-describedby="basic-addon2" name="message">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Button</button>
            </div>
        </div>
    </form>

    @php
            $my_variable = 0;
    @endphp

    @foreach ($listMessages as $listMessage)

            @if($my_variable == 0)
                <div class="input-group">
                    <p class="w-75 p-3">Message: {{ $listMessage->content }}</p> 
                    

                    <form method="post" action="{{ route('deleteMessage', $listMessage->id) }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                        <button class="btn btn-outline-secondary" type="submit">Delete</button>
                    </form>

                </div>
            @else
                <div class="input-group">
                    <p class="w-75 p-3">Message: {{ $listMessage->content }}</p> 
                    

                    <form method="post" action="{{ route('deleteMessage', $listMessage->id) }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                        <button class="btn btn-outline-secondary" type="submit">Delete</button>
                    </form>

                    <form method="post" action="{{ route('upMessage', $listMessage->id) }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                        <button class="btn btn-outline-secondary" type="submit">Up</button>
                    </form>

                </div>
            @endif


        @php
            $my_variable++;
        @endphp

    @endforeach

    
</div>
@endsection
