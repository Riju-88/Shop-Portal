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

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    // Submit form
    public function submit()
    {
        // Validate form
        $this->validate();

        // Create contact message and save to database
        $contact = Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        // details array containing name, email, subject and message for email
        $details = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];

        // get admin email from .env
        $adminEmail = env('MAIL_FROM_ADDRESS');

        // Send email to admin with details array
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

        // Email sent successfully
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
