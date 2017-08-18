<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTablesForContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('website_id')->unsigned()->nullable()->after('id');
            $table->integer('contact_id')->unsigned()->nullable()->after('website_id');

            $table->foreign('website_id')
                ->references('id')->on('websites')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->after('id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
