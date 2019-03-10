<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployeesReservations extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->integer('employee_name');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->dropColumn('employee_name');
        });
    }
}
