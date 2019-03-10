<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployees3 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
