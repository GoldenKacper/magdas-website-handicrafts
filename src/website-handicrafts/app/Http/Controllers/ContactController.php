<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the application Contact Page.
     */
    public function index()
    {
        $faqs = Faq::forFrontend()->get();

        $page = 'contact';
        // render contact view
        return view('pages.contact', compact('page', 'faqs'));
    }

    public function store(ContactRequest $request)
    {
        $data = $request->validated();

        try {
            // 1) To Ms. Magda (customer service)
            Mail::to(config('mail.from.address', 'magda.handicrafts@gmail.com'))
                ->send(new ContactMessageReceived($data));

            // sleep(2); // sometimes the mail server cannot handle two emails without a time interval between them

            // 2) To user (confirmation)
            Mail::to($data['email'])->send(new ContactMessageConfirmation($data));
        } catch (\Throwable $e) {
            // Log the error for developers
            Log::error('Contact form mail sending failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data'  => $data,
            ]);

            return redirect()
                ->route('contact', ['locale' => session('locale', app()->getLocale())])
                ->with('error', __('messages.contact_form_error'));
        }

        return redirect()
            ->route('contact', ['locale' => session('locale', app()->getLocale())])
            ->with('status', __('messages.contact_form_acknowledgement'));
    }
}
