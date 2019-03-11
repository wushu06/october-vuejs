<?php namespace Nourdigital\Nourdigital\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNourdigitalNourdigitalCalendar extends Migration
{
    public function up()
    {
        Schema::create('nourdigital_nourdigital_calendar', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('weekends');
            $table->string('slot');
            $table->time('business_hours_start');
            $table->time('business_hours_send');
            $table->string('date_range');
            $table->dateTime('disabled_date');
            $table->text('calendar_view');
            $table->integer('employee_id')->nullable();
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nourdigital_nourdigital_calendar');
    }
}
