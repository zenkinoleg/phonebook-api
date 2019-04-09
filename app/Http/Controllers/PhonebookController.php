<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\AppStats;
use App\Models\Phonebook;
//use App\Http\Traits\AppResponses;
use DB;

class PhonebookController extends Controller
{
//    use ResponseHelpers;
	use \App\Http\Traits\AppResponses;

	private $stats;

	public function __construct(AppStats $stats) {
		$this->stats = $stats;
	}

    /**
     * Load one record if `id` is presented, otherwise load collection
     * using `name` filter if presented
     *
     * @param int|null $id
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request, ?int $id = 0): JsonResponse
    {
		$this->stats->click('Get Phonebook Start');
        $page = $request->input('page', 0);
        $name = $request->input('name', '');
        if (!is_numeric($page)) {
            return $this->bad_request();
        }
        if ($id && !Phonebook::find($id)) {
            return $this->not_found();
        }
        if ($id) {
            return $this->success(Phonebook::find($id)->first());
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
		$this->stats->click('Get Phonebook End');
        return $this->success($model);
    }

    /**
     * Update record if `id` is presented, otherwise create new one
     *
     * @param int|null $id
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request, ?int $id = 0): JsonResponse
    {
        if ($id && !Phonebook::find($id)) {
            return $this->not_found();
        }
        $this->validate($request, Phonebook::rules($id));
        $model = Phonebook::updateOrCreate(
            [ 'id' => $id ],
            $request->all()
        );
        return $this->updated($model);
    }

    /**
     * Delete record by `id`
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function delete($id)
    {
        if ($id && !Phonebook::find($id)) {
            return $this->not_found();
        }
        $model = Phonebook::find($id);
        $clone = clone $model;
        $model->delete();
        return $this->deleted($clone);
    }
}
