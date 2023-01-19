<?php

namespace App\Http\Requests\Lotus;

use App\Models\LotusReservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class LotusReserveTicketRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules ()
    {
        return [
            'holder_type'    => 'required|in:student,general',
            'name'           => 'required|string',
            'email'          => 'required|email',
            'tickets'        => 'required|integer|min:1|max:3',
            'affiliation'    => 'nullable|string',
            'dietary'        => 'nullable|string',
            'accommodations' => 'nullable|string',
        ];
    }


    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator (Validator $validator)
    {
        //        $validator->after(function (Validator $validator) {
        //            if ($this->get('holder_type') === 'student' && $this->get('tickets') > 1) {
        //                $validator->errors()
        //                          ->add('tickets', 'Students may only reserve 1 ticket.');
        //            }
        //        });

        $validator->after(function (Validator $validator) {
            if ($this->isStudent() && !str_ends_with($this->get('email'), '@uab.edu') && !str_ends_with($this->get('email'), '@uabmc.edu')) {
                $validator->errors()
                          ->add('email', 'Must be a @uab.edu or @uabmc.edu email.');
            }
        });

        $validator->after(function (Validator $validator) {
            if (!LotusReservation::acceptingNewReservations()) {
                $validator->errors()
                          ->add('error', 'Ticket sales are currently disabled.');
            }
        });

        $validator->after(function (Validator $validator) {
            if (LotusReservation::isSoldOut()) {
                $validator->errors()
                          ->add('error', 'All tickets are currently sold out.');
            }
        });

        $validator->after(function (Validator $validator) {
            if ($this->get('holder_type') === 'student' && LotusReservation::isSoldOutForStudents()) {
                $validator->errors()
                          ->add('error', 'Student / Faculty tickets are currently sold out.');
            }
        });

        $validator->after(function (Validator $validator) {
            if ($this->get('holder_type') === 'general' && LotusReservation::isSoldOutForGeneral()) {
                $validator->errors()
                          ->add('error', 'General Admission tickets are currently sold out.');
            }
        });

        $validator->after(function (Validator $validator) {
            if ($this->get('tickets') > LotusReservation::remainingTickets()) {
                $validator->errors()
                          ->add('error', 'You cannot reserve more tickets than are available.');
            }
        });
    }

    public function messages ()
    {
        return [
            'holder_type.required' => 'You must select your status.',
            'tickets.max'          => 'You cannot reserve more than 3 tickets.',
        ];
    }


    public function isStudent ()
    {
        return $this->get('holder_type') === 'student';
    }
}
