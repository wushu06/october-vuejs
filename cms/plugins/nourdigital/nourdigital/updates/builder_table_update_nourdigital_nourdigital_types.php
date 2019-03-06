<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalTypes extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_types', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('type')->change();
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_types', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->increments('id')->unsigned()->change();
            $table->string('type', 191)->change();
        });
    }
}
