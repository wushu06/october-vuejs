<?php namespace Nourdigital\Nourdigital\Models;

use Model;

/**
 * Model
 */
class Employee extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nourdigital_nourdigital_employees';


    public $belongsToMany = [

        'reservation'=> [
            'nourdigital\nourdigital\models\Reservation', // define the model where the data is coming from
            'table' => 'nourdigital_nourdigital_employees_reservations', // the table where the data is coming from

        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
