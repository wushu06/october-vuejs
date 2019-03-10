<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalReservations3 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_reservations', function($table)
        {
            $table->text('employee_name');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_reservations', function($table)
        {
            $table->dropColumn('employee_name');
        });
    }
}
