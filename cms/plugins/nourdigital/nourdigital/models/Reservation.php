<?php namespace Nourdigital\Nourdigital\Models;

use Model;

/**
 * Model
 */

class Reservation extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $belongsTo = [
        'type' => 'nourdigital\nourdigital\models\Type',
        'user' => 'RainLab\User\Models\User',
       // 'employee' =>  'nourdigital\nourdigital\models\Employee'
    ];

    public $belongsToMany = [

        'employee'=> [
            'nourdigital\nourdigital\models\Employee', // define the model where the data is coming from
            'table' => 'nourdigital_nourdigital_employees_reservations', // the table where the data is coming from
            'order'=> 'job_title'
        ]
    ];





    /**
     * @var string The database table used by the model.
     */
    public $table = 'nourdigital_nourdigital_reservations';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
