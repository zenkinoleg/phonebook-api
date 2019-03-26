<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Phonebook;

class PhonebookController extends Controller
{
    use ResponseHelpers;

    /**
     * Load one record if `id` is presented, otherwise load collection
     *
     * @param int|null $id
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request, ?int $id = 0): JsonResponse
    {
        $page = $request->input('page', 0);
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
        if ($page) {
            $query = $query->skip(($page-1) * env('PAGE_SIZE'))
                ->take(env('PAGE_SIZE'));
        }
        $model = $query->get();
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
