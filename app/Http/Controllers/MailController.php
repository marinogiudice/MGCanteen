<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Models\MailMessage;
use App\Rules\Captcha;

/**
* Mail Controller Class.
* The Class Manages the operations to sedn a mail message
* through the contact us page form.
* Usess the Model Class MailMessage
* and the Captcha Rule.
* 
* @author Marino Giudice
*
*/

class MailController extends Controller
{
    public function index() {
        //gets the master categories
        
        $cart=null;
        //gets the cart from the session
        if(Session::has('cart')) {
            $cart=Session::get('cart');
        }
        return view('public.contacts', ['cart' => $cart]);
    }

    public function send_message(Request $request) {
       
        $request->validate([
            //validates the input fields
            'name' =>'bail|required|bail|max:60|bail|regex:/(^(([a-zA-Z0-9]*)+)([A-Za-z0-9 ]*)?$)/',
            'email' => 'bail|required|bail|email',
            'message' => 'bail|max:280|bail|required|regex:/(^(([a-zA-Z0-9.,:óíúéá ]*)+)([A-Za-z0-9.,:óíúéá ]*)?$)/',
            'g-recaptcha-response' => ['required', new Captcha],
        ]);

        //retrieves the required data from the request
        //and creates a MailMessage Object.
        $mail = new MailMessage($request->name, $request->email, 'admin@marinogiudice.co.uk','Request info', $request->message);
        if($mail->send()) {
            return redirect('/contactus')->with('status', 'Message Sent');
        } else {
            return redirect('/contactus')->with('status', 'Impossible send the message');
            
        }

    }
}

    

