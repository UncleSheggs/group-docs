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
        Schema::create('groups', function (Blueprint $table): void {
            $table->id();
            // $table->foreignId(column: 'user_id')
            //     ->constrained();
            $table->foreignId(column: 'service_id')
                ->constrained();
            $table->string(column: 'name', length: 50);
            $table->string(column: 'interval', length: 9);
            $table->tinyInteger(column: 'limit');
            $table->engine = 'InnoDB';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
