<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_is_sent_to_the_configured_contact_address(): void
    {
        Mail::fake();
        config(['mail.contact_address' => 'inbox@example.com']);

        $this->post(route('contact.send'), [
            'name' => 'Test Client',
            'phone' => '20123456',
            'email' => 'client@example.com',
            'message' => 'Bonjour WattLoc',
        ])->assertRedirect(route('contact'));

    }
}
