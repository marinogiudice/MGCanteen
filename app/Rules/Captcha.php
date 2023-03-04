<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class Captcha implements Rule
{
    
    /**
     * The Class Creates a new rule instance for the google
     * recaptcha field present in the contact us page.
     * USes the Recaptcha Class provided from google.
     *
     * @return void
     * 
     * @author Marino Giudice
     */

    public function __construct()
    {
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //create recaptcha obj 
        $recaptcha= new ReCaptcha( '6Lc9fvgiAAAAAMhtZsRbEb08RLf5fMD4l7jBVPwp' );
        //gets the response from google
        $resp = $recaptcha->setExpectedHostname( $_SERVER['HTTP_HOST'] )->verify( $value, $_SERVER['REMOTE_ADDR'] );
        //check if the response is valid
        if($resp->isSuccess()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please check captcha.';
    }
}
