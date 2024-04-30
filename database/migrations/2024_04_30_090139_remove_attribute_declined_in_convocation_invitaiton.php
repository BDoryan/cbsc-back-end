<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAttributeDeclinedInConvocationInvitaiton extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->dropColumn('declined');
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
            $table->boolean('declined')->nullable();
        });
    }
}
