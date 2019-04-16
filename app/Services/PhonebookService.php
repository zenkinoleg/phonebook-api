<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Phonebook;

class PhonebookService
{
    public function loadModel(Request $request, ?int $id = 0,$page = 1)
    {
        $name = $request->input('name', '');
        if ($id) {
            return Phonebook::find($id);
        }
        $query = Phonebook::orderBy('id');
        if ($name) {
            $query = $query->where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%");
        }
        if ($page) {
            $query = $query->skip(($page-1) * env('PAGE_SIZE'))
                ->take(env('PAGE_SIZE'));
        }
        $model = $query->get();

        return $model;
    }
}
