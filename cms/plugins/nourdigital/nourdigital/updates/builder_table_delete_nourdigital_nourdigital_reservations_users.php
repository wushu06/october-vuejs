<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteNourdigitalNourdigitalReservationsUsers extends Migration
{
    public function up()
    {
        Schema::dropIfExists('nourdigital_nourdigital_reservations_users');
    }
    
    public function down()
    {
        Schema::create('nourdigital_nourdigital_reservations_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('reservation_id');
            $table->integer('user_id');
        });
    }
}
