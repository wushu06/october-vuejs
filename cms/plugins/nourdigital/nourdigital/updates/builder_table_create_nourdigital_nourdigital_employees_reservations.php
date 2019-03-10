<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNourdigitalNourdigitalEmployeesReservations extends Migration
{
    public function up()
    {
        Schema::create('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('reservation_id');
            $table->integer('employee_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nourdigital_nourdigital_employees_reservations');
    }
}
