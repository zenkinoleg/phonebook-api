<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\AppStats;
use App\Services\PhonebookService;
use App\Models\Phonebook;

//use DB;

class PhonebookController extends Controller
{
    use \App\Http\Traits\AppResponses;

    private $stats;
    private $phonebookService;

    public function __construct(AppStats $stats, PhonebookService $phonebookService)
    {
        $this->stats = $stats;
        $this->phonebookService = $phonebookService;
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
        $page = $request->input('page', 1);
        if (!is_numeric($page)) {
            return $this->badRequest();
        }
        $model = $this->phonebookService->loadModel($request, $id, $page);
        if (!$model) {
            return $this->notFound();
        }
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
            return $this->notFound();
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
            return $this->notFound();
        }
        $model = Phonebook::find($id);
        $clone = clone $model;
        $model->delete();
        return $this->deleted($clone);
    }
}
