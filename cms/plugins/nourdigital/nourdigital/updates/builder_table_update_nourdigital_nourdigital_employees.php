<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalEmployees extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
            $table->string('email')->change();
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_employees', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
            $table->string('email', 191)->change();
        });
    }
}
