<?php

namespace App\Traits;

/**
 * Trait ModelTransform
 * 
 *
 */
trait ModelTransform
{
    public function transform($model = null, $transformer = null)
    {
        if (!$transformer) {
            if ($this->transformer) {
                $transformer = $this->transformer;
            } else {
                $elements = explode('\\', get_class($this));
                $transformer = '\\App\\Transformers\\' . $elements[2] . 'Transformer';
            }
        }

        $resource = fractal($this, $transformer);
        return $resource->toArray();
    }
}
