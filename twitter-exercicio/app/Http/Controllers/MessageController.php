<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MessageController extends Controller
{
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['listMessages' => Message::all()]);
    }

    //save all the messages in the database
    public function saveMessage(Request $request){

        
        //dd($request->message, auth()->user()->id);
        $user = User::find(1);

        $newMessage = new Message;
        $newMessage->user_id = auth()->user()->id;
        $newMessage->content = $request->message;
        $newMessage->position =0;
        $newMessage->save();
        

        return redirect('/home');

    }

    //delete a message in database
    public function deleteMessage($id)
    {
        Message::findOrFail($id)->delete();
   
        return redirect('/home');
    }
}
