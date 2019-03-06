<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNourdigitalNourdigitalReservations extends Migration
{
    public function up()
    {
        Schema::create('nourdigital_nourdigital_reservations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->dateTime('date');
            $table->string('type');
            $table->integer('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nourdigital_nourdigital_reservations');
    }
}
