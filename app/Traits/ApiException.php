<?php

namespace App\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait ApiException
{

    /**
     * Trata as exceções da API.
     *
     * @param Exception $exception
     */
    public function getJsonException($request, $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticatedException();
        }

        if ($exception instanceof UnauthorizedHttpException) {

            return $this->unauthenticatedException();
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->modelNotFoundException($exception);
        }

        if($exception instanceof NotFoundHttpException) {
            return $this->routeNotFoundException($exception);
        }

        if ($exception instanceof ValidationException) {
            return $this->validationException($exception);
        }

        return $this->genericException();
    }


    /**
     * Retorna erros de validação.
     * 
     * @param ValidationException
     */
    protected function validationException($exception)
    {
        return response()->json([
            "error" => $exception->errors(),
            "errCode" => $exception->status
        ], $exception->status);
    }

    /**
     * Retorna o erro 404 quando não encontra o recurso que foi buscado.
     * 
     * @param ModelNotFoundException
     */
    protected function modelNotFoundException($exception)
    {
        return $this->getResponse(404, $this->getModelNotFoundValidationMessage($exception), Response::HTTP_NOT_FOUND);
    }

    /**
     * Retorna o erro 404 quando não encontra a rota que foi buscada.
     * 
     * @param NotFoundHttpException
     */
    protected function routeNotFoundException($exception)
    {
        return $this->getResponse(404, 'Rota não encontrada.', Response::HTTP_NOT_FOUND);
    }

    /**
     * Retorna o erro 401.
     *
     */
    protected function unauthenticatedException()
    {
        return $this->getResponse(401, "Por favor, realize o login.", Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Retorna um erro genérico em JSON, com código, a mensagem de erro e o status.
     * 
     * @param Exception|null $exception
     */
    protected function genericException($exception = null)
    {
        return response()->json([
            'errCode' => 500,
            'error' =>  "Erro interno do servidor"
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Retorna o erro em JSON, com código, a mensagem de erro e o status.
     *
     * @param int $errCode
     * @param string $error
     * @param int $status
     */
    protected function getResponse($errCode, $error, $status)
    {
        return response()->json([
            'errCode' => $errCode,
            'error' =>  $error
        ], $status);
    }

    /**
     * Retorna o erro 404.
     *
     * @param ModelNotFoundException $exception
     */
    protected function getModelNotFoundValidationMessage($exception)
    {
        $model = $exception->getModel();
        return $model::$validationMessages['error.not_found'];
    }
}
