<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        try {
            Schema::create('cinema', function (Blueprint $table){
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->timestamps();

                $table->index('slug');
            });

            Schema::create('locations', function (Blueprint $table){
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->timestamps();

                $table->index('slug');
            });

            Schema::create('movies', function (Blueprint $table){
                $table->id();
                $table->foreignId('cinema_id')->references('id')->on('cinema');
                $table->foreignId('location_id')->references('id')->on('locations');
                $table->string('movie_name');
                $table->string('movie_slug');
                $table->timestamps();

                $table->index('movie_slug');
            });

            Schema::create('shows', function (Blueprint $table){
                $table->id();
                $table->foreignId('movie_id')->references('id')->on('movies');
                $table->dateTime('start_time');
                $table->dateTime('end_time');
                $table->boolean('is_booked_out')->default(0);
                $table->timestamps();
            });

            Schema::create('seat_types', function (Blueprint $table){
                $table->id();
                $table->foreignId('show_id')->references('id')->on('shows');
                $table->string('seat_category_name');
                $table->string('seat_category_slug');
                $table->integer('price');
                $table->timestamps();

                $table->index('seat_category_slug');
            });

            Schema::create('bookings', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id')->references('id')->on('users');
                $table->foreignId('seat_type_id')->references('id')->on('seat_types');
                $table->foreignId('show_id')->references('id')->on('shows');
                $table->integer('seat_number');
                $table->timestamps();
            });

        }catch (Exception $exception){
            throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
