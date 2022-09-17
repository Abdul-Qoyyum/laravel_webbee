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
//        throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price', 8, 2);
            $table->string('seat_number');
            $table->date('show_date');
            $table->time('show_time');
            $table->boolean('is_booked_out')->default(false); //indicates movies with available seats
            $table->enum('seat_type', ['default','seat_couple','seat_super','vip']); //we can calculate price based on the seat_type
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); //owner
        });

        //many-to-many relationship with the user
        Schema::create('user_cinema', function (Blueprint $table){
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('movie_id')->references('id')->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('user_cinema');
    }
}
