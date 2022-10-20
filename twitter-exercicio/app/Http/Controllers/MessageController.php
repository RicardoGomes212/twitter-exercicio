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

        # Get the element position from the last message added 
        $last = Message::latest()->first();
        # Get the highest position
        $highest = Message::max('position');

        # IF is null a new message will be added with position 0 else the position value will be +1 than the highest position
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
        
        #redirect to home page
        return redirect('/home');

    }

    //delete a message in database
    public function deleteMessage($id)
    {
        #find the message by id
        $message = Message::find($id);
        


        #for each message with a position  below the one witch we want to remove, this position is gonna be updated by removing 1 position to each element
        for ($i = $message->position + 1; $i <= $highest = Message::max('position'); $i++) {

            $messageNext=Message::where('position', $i)->first();
            $messageNext->position=$messageNext->position-1;
            $messageNext->save();
        }

        #delete message
        Message::findOrFail($id)->delete();

        
        return redirect('/home');    
    }

    //move a message up
    public function upMessage($id)
    {

        #find message by 
        $message = Message::find($id); 

        #switches the position value from the selected message to the message bellow
        $nextposition= $message->position+1;
        $messageNext=Message::where('position', $nextposition)->first();
        $messageNext->position=$nextposition-1;
        $messageNext->save();
        $message->position=$message->position+1;
        $message->save();
        
        #redirect to home page
        return redirect('/home');
    }

    //move a message down
    public function downMessage($id)
    {
        #find message by
        $message = Message::find($id); 

        #switches the position value from the selected message to the message above
        $nextposition= $message->position-1;
        $messageNext=Message::where('position', $nextposition)->first();
        $messageNext->position=$nextposition+1;
        $messageNext->save();
        $message->position=$message->position-1;
        $message->save();
        
        #redirect to home page
        return redirect('/home');
    }
}
