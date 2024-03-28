<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAttributesConvocationInvitations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->dropColumn('accepted');
        });

        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->dropColumn('declined');
        });

        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->dropColumn('responded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->boolean('accepted')->default(false);
        });

        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->boolean('declined')->default(false);
        });

        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->timestamp('responded_at')->nullable();
        });
    }
}
