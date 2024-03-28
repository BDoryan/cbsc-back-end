<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvocationInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocation_invitations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->foreignId('convocation_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->boolean('accepted')->default(false);
            $table->boolean('declined')->default(false);
            $table->dateTime('responded_at')->nullable();
            $table->unique(['convocation_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convocation_invitations');

        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->dropForeign(['convocation_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
