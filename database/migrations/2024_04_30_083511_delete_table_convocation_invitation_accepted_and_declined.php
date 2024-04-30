<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTableConvocationInvitationAcceptedAndDeclined extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('convocation_invitations_accepted');
        Schema::dropIfExists('convocation_invitations_declined');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('convocation_invitations_accepted', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocation_invitation_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('convocation_invitations_declined', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocation_invitation_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
}
