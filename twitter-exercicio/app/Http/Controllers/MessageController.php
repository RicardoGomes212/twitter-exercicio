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
        #delete message
        Message::findOrFail($id)->delete();

        
        return redirect('/home');    
    }

    //move a message up
    public function upMessage($id)
    {

        #find message by id
        $message = Message::find($id); 

        #find message above
        $aboveSelected = Message::orderBy('position', 'asc')
                 ->where('position', '>', $message->position)
                 ->first();

        $above=$message->position;
        $selected=$aboveSelected->position;


        #switches the position value from the selected message to the message above
        $aboveSelected->position=$above;
        $aboveSelected->save();
        $message->position=$selected;
        $message->save();
        
        #redirect to home page
        return redirect('/home');
    }

    //move a message down
    public function downMessage($id)
    {
        #find message by id
        $message = Message::find($id); 

        #find message below
        $belowSelected = Message::orderBy('position', 'desc')
                 ->where('position', '<', $message->position)
                 ->first();

        $below=$message->position;
        $selected=$belowSelected->position;
        //dd($below, $selected);

        #switches the position value from the selected message to the message above
        $belowSelected->position=$below;
        $belowSelected->save();
        $message->position=$selected;
        $message->save();
        
        #redirect to home page
        return redirect('/home');
    }
}
