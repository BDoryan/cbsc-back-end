<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeToConvocationInvitation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convocation_invitations', function (Blueprint $table) {
            $table->addColumn('boolean', 'accepted')->nullable()->default(null);
            $table->addColumn('boolean', 'declined')->nullable()->default(null);
            $table->addColumn('timestamp', 'responded_at')->nullable();
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
            $table->dropColumn('accepted');
            $table->dropColumn('declined');
            $table->dropColumn('responded_at');
        });
    }
}
