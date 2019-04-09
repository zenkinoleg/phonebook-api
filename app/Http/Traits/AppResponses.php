<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait AppResponses
{
    protected function respond(?string $status, ?array $data = []) {
//		$stats = app(\App\Services\AppStats::class)->getData();
		$data['stats'] = $this->stats->getData(1);
        return response()->json($data, $status);
    }

    protected function not_found($data = [])
    {
        if (!isset($data['message'])) {
            $data['message'] = '404 Not Found';
        }
        return $this->respond(Response::HTTP_NOT_FOUND, $data);
    }

    protected function bad_request($data = [], $model = '')
    {
        if (!isset($data['message'])) {
            $data['message'] = '400 Bad Request';
        }
        if ($model) {
            $item = isset($model[0]) ? $model[0] : $model;
            $data['model'] = is_array($item) ? 'Array' : class_basename($item);
            $data['data'] = $model->toArray();
        }
        return $this->respond(Response::HTTP_BAD_REQUEST, $data);
    }

    protected function unauthorized(?string $message = '') {
		$data = [
			'status' => '401 Unauthorized',
			'message' => $message
		];
        return $this->respond(Response::HTTP_UNAUTHORIZED, $data);
    }

    protected function forbidden(?string $message = '') {
		$data = [
			'status' => '403 Forbidden',
			'message' => $message
		];
        return $this->respond(Response::HTTP_FORBIDDEN, $data);
    }

    protected function success($model = '')
    {
        if (!$model) {
            return $this->respond(Response::HTTP_OK);
        }
        if (is_array($model)) {
            return $this->respond(Response::HTTP_OK, $model);
        }
        $item = isset($model[0]) ? $model[0] : $model;
        $data = [];
        $data['model'] = class_basename($item);
        $count = is_countable($model) ? count($model) : 1;
        $data['message'] = '200 Succesfully retrieved. ' . $count . ' items fetched';
        $data['data'] = $model->toArray();

        return $this->respond(Response::HTTP_OK, $data);
    }

    protected function updated($model = '')
    {
        if (!$model) {
            return $this->respond(Response::HTTP_OK);
        }

        $data = [];
        $data['model'] = class_basename($model);
        $data['data'] = $model->toArray();
        $data['message'] = '200 Record Updated';

        return $this->respond(Response::HTTP_OK, $data);
    }

    protected function deleted($model = '')
    {
        if (!$model) {
            return $this->respond(Response::HTTP_OK);
        }
        $data = [
            'model' => class_basename($model),
            'data' => $model->toArray(),
            'message' => '200 Record Deleted'
        ];
        return $this->respond(Response::HTTP_OK, $data);
    }
}
