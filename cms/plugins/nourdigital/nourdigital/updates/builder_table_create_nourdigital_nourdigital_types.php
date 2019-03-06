<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNourdigitalNourdigitalTypes extends Migration
{
    public function up()
    {
        Schema::create('nourdigital_nourdigital_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nourdigital_nourdigital_types');
    }
}
