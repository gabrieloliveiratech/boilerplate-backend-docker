<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name' => (string)$user->name,
            'username' => (string)$user->username,
            'email' => (string)$user->email,
            'birth_date' => (string)$user->email,
            'profile_id' => (int) $user->profile_id,
        ];
    }
}
