<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployees7 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->renameColumn('em_name', 'name');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->renameColumn('name', 'em_name');
        });
    }
}
