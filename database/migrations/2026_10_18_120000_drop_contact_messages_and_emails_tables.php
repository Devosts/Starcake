<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('emails');
    }

    public function down(): void
    {
        // Intentionally empty: the contact-messages and IMAP email features
        // were removed from the application.
    }
};
