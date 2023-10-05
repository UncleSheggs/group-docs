<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table): void {
            $table->id();
            $table->foreignId(column: 'group_id')->constrained();
            $table->foreignId(column: 'user_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string(column: 'role', length: 6);
            $table->string(column: 'status', length: 7)
                ->default(\App\Enums\MembershipStatus::PENDING->value);
            $table->engine = 'InnoDB';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
