<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Link to the user making the purchase
            $table->foreignIdFor(User::class, 'customer_id')
                ->constrained('users')
                ->onDelete('cascade');
            // Link to the merchant receiving the purchase
            $table->foreignIdFor(User::class, 'merchant_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->decimal('amount', 10, 2); // Handles money (e.g., 99999999.99)
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
