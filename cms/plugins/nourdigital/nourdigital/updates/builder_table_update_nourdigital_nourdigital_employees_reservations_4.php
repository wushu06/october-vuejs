<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployeesReservations4 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->increments('id');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees_reservations', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
