<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteNourdigitalNourdigitalEmployees extends Migration
{
    public function up()
    {
        Schema::dropIfExists('nourdigital_nourdigital_employees');
    }
    
    public function down()
    {
        Schema::create('nourdigital_nourdigital_employees', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 191);
            $table->string('email', 191);
            $table->integer('reservation_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
}
