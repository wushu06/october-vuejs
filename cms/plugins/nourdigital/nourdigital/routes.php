<?php

use nourdigital\nourdigital\models\Type;
use nourdigital\nourdigital\models\Reservation;
use nourdigital\nourdigital\models\Employee;
//use RainLab\User\Models\User;
use Nourdigital\Nourdigital\Models\Calendar;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

// get request
Route::get('types', function () {
    $types = Type::all();
    return $types;
});


// - 4 - in the routes define the relation in the returned result
Route::get('reservations', function () {
    $reservation = Reservation::with(['type', 'user', 'employee'])->get();

    return $reservation;
});

Route::get('employees', function () {
    $employees = Employee::all();
    return $employees;
});

Route::get('users', function () {
    $employees = User::all();
    return $employees;
});
Route::get('calendar', function () {
    $calendar = Calendar::all();
    return $calendar;
});

// jobs by id and reservations by id are the same

Route::get('reservations/employee/{id}', function ($id) {
    $reservation =  DB::table('nourdigital_nourdigital_reservations as reservation')
        ->select('reservation.id','date','name', 'email','type', 'user_id', 'reservation.type_id', 'reservation.employee_id')
        ->join('users', 'reservation.user_id', '=', 'users.id')
        ->join('nourdigital_nourdigital_types as type',  'reservation.type_id', '=', 'type.id')
        ->where('reservation.employee_id', '=', $id)->get();

    return $reservation;
});

Route::get('reservations/{id}', function ($id) {

    /*$reservation = Reservation::whereHas('user', function ($query) use ($id ) {
        $query->where('id', '=', $id);
    })->get();*/
    $reservation =  DB::table('nourdigital_nourdigital_reservations as reservation')
                    ->select('reservation.id','date','name', 'email','type', 'reservation.type_id')
                    ->join('users', 'reservation.user_id', '=', 'users.id')
                    ->join('nourdigital_nourdigital_types as type',  'reservation.type_id', '=', 'type.id')
                    ->where('users.id', '=', $id)->get();



    return $reservation;
});

Route::middleware(['api','jwt.auth'])->group(function () {
    Route::post('create-reservation', function (Request $request) {
        $reservation = new Reservation;
        $reservation->date = $request->date;
        $reservation->user_id = $request->user_id;
        $reservation->type_id = $request->type_id;
        $reservation->employee_id = $request->employee_id;
        $reservation->save();
        return response()->json('Reservation Created!');
    });

    Route::patch('editreservation/{id}', function (Request $request, $id) {

        $crud = Reservation::findOrFail($id);
        $crud->type_id = $request->type_id;
        $crud->date = $request->date;
        $crud->save();


        return response()->json('Reservation updated!');
    });

// Delete Contact
    Route::delete('deletereservation/{id}', function ($id) {

        return Reservation::destroy($id);
    });
});