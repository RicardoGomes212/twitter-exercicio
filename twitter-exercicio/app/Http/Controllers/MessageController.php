<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MessageController extends Controller
{



    //save all the messages in the database
    public function saveMessage(Request $request){

        
        //dd($request->message, auth()->user()->id);
        $user = User::find(1);

        $newMessage = new Message;
        $newMessage->user_id = auth()->user()->id;
        $newMessage->content = $request->message;
        $newMessage->position =0;
        $newMessage->save();
        
        //dd($request->message, $user->messages);

        return view('home');

    }
}
