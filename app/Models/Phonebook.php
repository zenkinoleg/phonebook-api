<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Rules\HostawayCountry;
use App\Rules\HostawayTimezone;

class Phonebook extends Model {

	protected $table = 'phonebook';

    protected $fillable = [
		'first_name',
		'last_name',
		'phone_number',
		'country',
		'timezone'
	];

    public static function rules($id): array {
        return [
	        'first_name' => ['required', 'string'],
    	    'last_name' => ['required', 'string'],
			'phone_number' => ['required', 'regex:/^\+\d{2} \d{3} \d{9}$/', "unique:phonebook,phone_number,$id" ],
	        'country' => [ 'required', 'string', 'min:2', 'max:2', new HostawayCountry ],
    	    'timezone' => ['required', 'string', new HostawayTimezone ],
	    ];
	}
}
