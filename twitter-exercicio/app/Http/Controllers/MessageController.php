<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\laravel;

class MessageController extends Controller
{
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['listMessages' => Message::all()->sortByDesc("position")]);
    }

    //save all the messages in the database
    public function saveMessage(Request $request){

        
        # Validation
        $request->validate([
            'message' => 'required'
        ]);


        $last = Message::latest()->first();
        $highest = Message::max('position');

        if(is_null($last)){
            $newMessage = new Message;
            $newMessage->user_id = auth()->user()->id;
            $newMessage->content = $request->message;
            $newMessage->position =0; 
            $newMessage->save();
        }
        else{
            $newMessage = new Message;
            $newMessage->user_id = auth()->user()->id;
            $newMessage->content = $request->message;
            $newMessage->position = $highest + 1; 
            $newMessage->save();
        }
        
        return redirect('/home');

    }

    //delete a message in database
    public function deleteMessage($id)
    {
        $message = Message::find($id);
        


    
        for ($i = $message->position + 1; $i <= $highest = Message::max('position'); $i++) {

            $messageNext=Message::where('position', $i)->first();
            $messageNext->position=$messageNext->position-1;
            $messageNext->save();
        }


        Message::findOrFail($id)->delete();

        
        return redirect('/home');    
    }

    //move a message up
    public function upMessage($id)
    {

        $message = Message::find($id); 
        $nextposition= $message->position+1;

        $messageNext=Message::where('position', $nextposition)->first();
        $messageNext->position=$nextposition-1;
        $messageNext->save();

        $message->position=$message->position+1;
        $message->save();
        
        return redirect('/home');
    }

    //move a message down
    public function downMessage($id)
    {
        $message = Message::find($id); 
        $nextposition= $message->position-1;

        $messageNext=Message::where('position', $nextposition)->first();
        $messageNext->position=$nextposition+1;
        $messageNext->save();

        $message->position=$message->position-1;
        $message->save();
        
        return redirect('/home');
    }
}
