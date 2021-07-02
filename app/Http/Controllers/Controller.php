<?php

namespace App\Http\Controllers;

use App\Traits\CollectionTransform;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;



class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CollectionTransform;

    /**
     * @param Model $model
     * @param int $code
     * @param null $transformer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function showOne(Model $model, $code = 200, $transformer = null)
    {
        return response()->json($model->transform($transformer), $code);
    }

    /**
     * @param Collection $collection
     * @param int $code
     * @param null $transformer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function showData(Collection $collection, $code = 200, $transformer = null)
    {
        $collection = $this->paginate($collection);
        $collection = $this->transformCollection($collection, $transformer);
        return response()->json($collection, $code);
    }

    /**
     * @param Collection $collection
     * @return LengthAwarePaginator|Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2'
        ];

        Validator::validate(request()->all(), $rules);
        $page = LengthAwarePaginator::resolveCurrentPage();

        $per_page = null;
        if (request()->has('per_page')) {
            $per_page = (int)request()->per_page;
        }
        if (!$per_page) {
            return $collection;
        }

        $results = $collection->slice(($page - 1) * $per_page, $per_page)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $per_page, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }
}
