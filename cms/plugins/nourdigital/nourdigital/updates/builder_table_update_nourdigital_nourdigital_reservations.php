<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalReservations extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_reservations', function($table)
        {
            $table->integer('type_id');
            $table->dropColumn('type');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_reservations', function($table)
        {
            $table->dropColumn('type_id');
            $table->string('type', 191);
        });
    }
}
