<?php

namespace App\Http\Response;



class Response extends \Illuminate\Http\JsonResponse {

	protected $metaBag = array();
	protected $responseData = array();
	protected $additionalHeaders = array();

	const FAILED = 'FAILED';
	const OK = 'OK';

	public function metaJson($data = array(), $status = 200, array $headers = array(), $options = 0) {


		$this->additionalHeaders = array_merge($this->additionalHeaders, $headers);
		$this->responseData = array_merge($this->responseData, $data);

		return new static(array(
							  'response' => $this->responseData), $status, $this->additionalHeaders, $options);
	}
	public function data($key, $value) {
		$this->responseData[$key] = $value;
		return $this;
	}

	public function headers($key, $value) {
		$this->additionalHeaders[$key] = $value;
		return $this;
	}
	public function withHeaders($headers = array()) {
		$this->additionalHeaders = array_merge($this->additionalHeaders, $headers);
		return $this;
	}

	public function error($data = null, $status = 500, array $headers = array()) {

		if ($data === null) {
			$data = 'something went wrong !';
		}

		if (is_string($data)) {
			$data = array('error' => trans($data));
		}

		return $this->metaJson($data, $status, $headers);
	}

	public function bad($data = null, $status = 400, array $headers = array()) {
		return $this->error($data, $status, $headers);
	}

	public function unauthorized($data = null, $status = 401, array $headers = array()) {
		return $this->error($data, $status, $headers);
	}

	public function forbidden($data = null, $status = 403, array $headers = array()) {
		return $this->error($data, $status, $headers);
	}

	public function notFound($data = null, $status = 404, array $headers = array()) {
		return $this->error($data, $status, $headers);
	}

	public function statusCode($value, $message = null, $status = 200, array $headers = array()) {

		$data = array();
		$data['status'] = $value;
		if ($message !== null) {
			if (is_array($message)) {
				$data = array_merge($data, $message);
			} else if (is_string($message)) {
				$data['message'] = trans($message);
			}
		}

		return $this->metaJson($data, $status, $headers);
	}

	public function exception($exception, $message = null, $status = 400, array $headers = array()) {

		$this->metaBag['status'] = static::FAILED;

		if (is_array($exception)) {
			$data = $exception;
		} else {
			$data = array('exception' => $exception . 'Exception');

			if ($message) {
				$data['message'] = trans($message);
			}
		}


		return $this->metaJson($data, $status, $headers);
	}

	public function statusOk($data = array(), $status = 200, array $headers = array()) {
		return $this->statusCode(static::OK, $data, $status, $headers);
	}

	public function statusFail($data = array(), $status =200, array $headers = array()) {
		$this->metaBag['status'] = static::FAILED;
		return $this->statusCode(static::FAILED, $data, $status, $headers);
	}



}
