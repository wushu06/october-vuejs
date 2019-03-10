<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNourdigitalNourdigitalEmployees2 extends Migration
{
    public function up()
    {
        Schema::create('nourdigital_nourdigital_employees', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nourdigital_nourdigital_employees');
    }
}
