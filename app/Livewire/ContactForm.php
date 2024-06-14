<?php

namespace App\Livewire;

use App\Mail\ContactMail;
use App\Models\Contact;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $contact = Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $details = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];

        $adminEmail = env('MAIL_FROM_ADDRESS');

        $mailSent = Mail::to($adminEmail)->send(new ContactMail($details));

        // Check if there are any failures
        if (!$mailSent) {
            // Email sending failed
            Notification::make()
                ->title('Something went wrong. Failed to send email.')
                ->error()
                ->send();
            return;
        }

        Notification::make()
            ->title('Email sent successfully.')
            ->success()
            ->send();

        $this->reset();  // Reset form fields
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
