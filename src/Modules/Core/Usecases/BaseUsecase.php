<?php


namespace LMS\Modules\Core\Usecases;

class BaseUsecase
{

    protected $response = false;
    protected $errors = false;
    protected $status = true;

    public function parseResponse()
    {
        return ['data' => $this->response, 'errors' => $this->errors];
    }
}
