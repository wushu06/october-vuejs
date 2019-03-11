<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNourdigitalNourdigitalCalendar extends Migration
{
    public function up()
    {
        Schema::table('nourdigital_nourdigital_calendar', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('weekends')->change();
            $table->string('slot')->change();
            $table->string('date_range')->change();
        });
    }
    
    public function down()
    {
        Schema::table('nourdigital_nourdigital_calendar', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->string('weekends', 191)->change();
            $table->string('slot', 191)->change();
            $table->string('date_range', 191)->change();
        });
    }
}
