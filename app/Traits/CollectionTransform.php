<?php

namespace App\Traits;

/**
 * Trait CollectionTransform
 * 
 *
 */
trait CollectionTransform
{
    public function transformCollection($collection = null, $transformer = null)
    {
        if($collection->isEmpty()){
            return response()->json(['data' => []]);
        }

        if (!$transformer) {
            $elements = explode('\\', get_class($collection[0]));
            $transformer = '\\App\\Transformers\\' . $elements[2] . 'Transformer';
        }

        $resource = fractal($collection, $transformer);

        return $resource->toArray();
    }
}
