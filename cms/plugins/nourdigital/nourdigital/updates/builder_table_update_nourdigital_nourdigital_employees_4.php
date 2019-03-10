<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployees4 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->renameColumn('name', 'job_title');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->renameColumn('job_title', 'name');
        });
    }
}
