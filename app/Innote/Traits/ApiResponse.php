<?php

namespace App\Innote\Traits;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Trait ApiResponse
 *
 * @package App\Innote\Traits
 */
trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = HttpResponse::HTTP_OK;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        if (null !== $statusCode && !is_numeric($statusCode)) {
            throw new \UnexpectedValueException(sprintf('The ApiResponse message must be a integer, "%s" given.', gettype($statusCode)));
        }
        $this->statusCode = (int)$statusCode;

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        if ( !$message) return $this;

        if (null !== $message && !is_string($message)) {
            throw new \UnexpectedValueException(sprintf('The ApiResponse message must be a string, "%s" given.', gettype($message)));
        }
        $this->message = (string)$message;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        if (empty($data)) return $this;

        if (null !== $data && !is_array($data)) {
            throw new \UnexpectedValueException(sprintf('The ApiResponse message must be a array, "%s" given.', gettype($data)));
        }
        $this->data = $data;

        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond()
    {
        return response()->json($this->data, $this->statusCode, $this->header);
    }

    /**
     * 200 成功响应
     *
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse(array $data = [], $message = 'Success')
    {
        return $this->setMessage($message)
            ->setData($data)
            ->respond();
    }

    /**
     * 500 服务端错误响应
     *
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = 'Internet Server Error', array $data = [], $statusCode = HttpResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->setStatusCode($statusCode)
            ->setMessage($message)
            ->setData($data)
            ->respond();
    }

    /**
     * 400 当前请求无法被服务器解析
     *
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function badRequestResponse($message = 'Bad Request', array $data = [])
    {
        return $this->errorResponse($message, $data, HttpResponse::HTTP_BAD_REQUEST);
    }

    /**
     * 400 当前请求参数缺失
     *
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function parameterMissingResponse($message = 'Parameter Missing', array $data = [])
    {
        return $this->errorResponse($message, $data, HttpResponse::HTTP_BAD_REQUEST);
    }
}