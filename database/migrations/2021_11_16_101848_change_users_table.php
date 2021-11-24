<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('role')->after('name');
            $table->string('courier')->after('role');
            $table->string('owner')->after('courier');
            $table->string('port')->after('owner');
            $table->string('address')->after('owner');
            $table->string('phone')->after('address');
            // $table->renameColumn('unique', 'courier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
