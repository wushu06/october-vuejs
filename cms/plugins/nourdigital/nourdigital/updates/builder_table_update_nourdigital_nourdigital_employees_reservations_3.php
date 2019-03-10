<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployeesReservations3 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->renameColumn('user_id', 'employee_id');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->renameColumn('employee_id', 'user_id');
        });
    }
}
