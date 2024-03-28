<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceLicenseIntToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // fetch date from licensed_users table
        $licensed_users = DB::table('licensed_users')->get();

        // remove the license_number column
        Schema::table('licensed_users', function (Blueprint $table) {
            $table->dropColumn('license_number');
        });

        Schema::table('licensed_users', function (Blueprint $table) {
            $table->string('license_number')->nullable();
        });

//         insert the license_number column with the data
        foreach ($licensed_users as $licensed_user) {
            DB::table('licensed_users')->insert([
                'license_number' => $licensed_user->license_number
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // fetch date from licensed_users table
        $licensed_users = DB::table('licensed_users')->get();

        // remove the license_number column
        Schema::table('licensed_users', function (Blueprint $table) {
            $table->dropColumn('license_number');
        });

        Schema::table('licensed_users', function (Blueprint $table) {
            $table->integer('license_number')->change();
        });

        // insert the license_number column with the data
        foreach ($licensed_users as $licensed_user) {
            DB::table('licensed_users')->insert([
                'license_number' => $licensed_user->license_number
            ]);
        }
    }
}
