<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait ResponseHelpers {

    protected function respond($status, $data = []) {
        return response()->json($data, $status);
    }

    protected function not_found($data = []) {
		if ( !isset($data['message']) ) {
			$data['message'] = '404 Not Found';
		}
		return $this->respond(Response::HTTP_NOT_FOUND,$data);
    }

    protected function bad_request($data = [], $model = '') {
		if ( !isset($data['message']) ) {
			$data['message'] = '400 Bad Request';
		}
		if ( $model ) {
			$item = isset($model[0]) ? $model[0] : $model;
			$data['model'] = is_array($item) ? 'Array' : class_basename($item);
			$data['data'] = $model->toArray();
		}
		return $this->respond(Response::HTTP_BAD_REQUEST,$data);
    }

    protected function forbidden($data = []) {
		if ( !isset($data['message']) ) {
			$data['message'] = '403 Forbidden';
		}
		return $this->respond(Response::HTTP_FORBIDDEN,$data);
    }

    protected function success($data='') {
		return $this->respond(Response::HTTP_OK,$data);
    }

    protected function updated($model = '') {
		if ( !$model ) {
			return $this->respond(Response::HTTP_OK);
		}

		$data = [];
		$data['model'] = class_basename($model);
		$data['data'] = $model->toArray();
		$data['message'] = '200 Record Updated';

		return $this->respond(Response::HTTP_OK,$data);
    }

    protected function created($model = '') {
		if ( !$model ) {
			return $this->respond(Response::HTTP_OK);
		}

		$data = [];
		$data['model'] = class_basename($model);
		$data['data'] = $model->toArray();
		$data['message'] = '200 Record Created';

		return $this->respond(Response::HTTP_CREATED,$data);
    }

    protected function deleted($model='') {
		if ( !$model ) {
			return $this->respond(Response::HTTP_OK);
		}
		$data = [
			'model' => class_basename($model),
			'data' => $model->toArray(),
			'message' => '200 Record Deleted'
		];
		return $this->respond(Response::HTTP_OK,$data);
    }

}
