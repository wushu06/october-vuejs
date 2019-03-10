<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployees9 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->integer('reservation_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->integer('reservation_id')->nullable(false)->change();
        });
    }
}
