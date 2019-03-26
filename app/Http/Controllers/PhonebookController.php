<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
//use App\Models\Phone;

class PhonebookController extends Controller
{
    use ResponseHelpers;

	protected $country_codes;
	protected $timezones;

	public function __construct() {
		$this->country_codes = Cache::get('country_codes');
		$this->timezone = Cache::get('timezones');
	}

	public function get(Request $request,?int $id=0) {
_prnt($this,1);
	}
}
