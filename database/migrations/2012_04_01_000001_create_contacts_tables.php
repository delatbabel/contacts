<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('street')->nullable();
            $table->string('suburb', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('postcode', 50)->nullable();
            $table->string('country_name', 255)->nullable();
            $table->string('country_code', 8)->nullable();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_phone', 255)->nullable();
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lng', 10, 6)->nullable();
            $table->longText('notes')->nullable();
            $table->longText('extended_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('companies', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('company_name', 255)->nullable()->index();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_phone', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->longText('notes')->nullable();
            $table->longText('extended_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contacts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable()->index();
            $table->string('full_name', 255)->nullable()->index();
            $table->string('company_name', 255)->nullable()->index();
            $table->string('position', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('timezone', 255)->nullable();
            $table->longText('notes')->nullable();
            $table->longText('extended_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('address_contact', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->string('address_type', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreign('address_id')
                ->references('id')->on('addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('address_company', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('address_type', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreign('address_id')
                ->references('id')->on('addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('category_company', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('company_id')->unsigned();

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('category_contact', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('contact_id')->unsigned();

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('contact_id')
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
        Schema::drop('addresses');
        Schema::drop('contacts');
    }
}
