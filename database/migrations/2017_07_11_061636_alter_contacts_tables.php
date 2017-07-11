<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContactsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function($table) {
            $table->string('established')->nullable();
            $table->string('size')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('logo')->nullable();
            $table->string('current_project_list')->nullable();
            $table->string('past_project_list')->nullable();
            $table->string('invoice_email')->nullable();
        });

        Schema::create('category_company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->nullableTimestamps();

            $table->unique(['category_id', 'company_id']);

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
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
        Schema::table('companies', function($table) {
            $table->dropColumn('established');
            $table->dropColumn('size');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('linkedin');
            $table->dropColumn('logo');
            $table->dropColumn('invoice_email');
            $table->dropColumn('current_project_list');
            $table->dropColumn('past_project_list');
        });
        Schema::drop('category_company');
    }
}
