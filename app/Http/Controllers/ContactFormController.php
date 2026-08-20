<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\ContactFormRequest;
use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function contactFormStore (ContactFormRequest $request) {
        $formFields = $request->validated();
        Mail::to(config('app.admin_mail'))->send(new ContactEmail($formFields['email'],$formFields['message']));
    }
}
