<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Exceptions\V1\FailureException;

use Illuminate\Pagination\LengthAwarePaginator;

use Exception;

class BaseResponse extends JsonResource
{
    private $error = null;
    private $message = "Operation successful";
    private $data = null;
    private $success = true;

    public function __construct($data, ?Exception $error = null, $success = true, $message = null)
    {
        $this->data = $data;
        $this->success = $success;
        $this->message = is_null($message) ? $this->message : $message;

        if (!is_null($error)) {
            $this->error = [
                'code' => 'ECOMM-' . $error->getCode(),
                'message' => $error->getMessage()
            ];
        } else {
            $this->error = (object) array();
        }

        parent::__construct($data);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // throw FailureException::serverError();
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array
     */
    public function wrapped($response = [])
    {
        return [
            "data" => $response,
            "error" => $this->error,
            "success" => $this->success,
            "message" => $this->message
        ];
    }
}
