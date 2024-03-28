<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvocationInvitationAcceptedAndConvocationInvitiationDenied extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocation_invitations_accepted', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Relier à l'invitation de la convocation
            $table->foreignId('convocation_invitation_id')->constrained()->onDelete('cascade');
        });

        Schema::create('convocation_invitations_declined', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Relier à l'invitation de la convocation
            $table->foreignId('convocation_invitation_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convocation_invitations_accepted');
        Schema::dropIfExists('convocation_invitations_declined');
    }
}
