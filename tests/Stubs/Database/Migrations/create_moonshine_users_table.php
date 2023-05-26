<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoonShineUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('moonshine_users', function (Blueprint $table): void {
            $table->id();

            $table->bigInteger('moonshine_user_role_id')
                ->default(1);

            $table->string('email', 190)->unique();
            $table->string('password', 60);
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moonshine_users');
    }
}
