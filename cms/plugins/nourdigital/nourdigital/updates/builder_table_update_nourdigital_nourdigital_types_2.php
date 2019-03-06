<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalTypes2 extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_types', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_types', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
