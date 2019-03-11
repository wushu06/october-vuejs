<?php namespace Nourdigital\Nourdigital\Models;

use Model;

/**
 * Model
 */
class Calendar extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nourdigital_nourdigital_calendar';
    protected $jsonable = ['disabled_date'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
