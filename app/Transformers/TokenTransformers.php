<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Token;

class TokenTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Token $token)
    {
        return [
            'Id_Token'  => $token->Id_Token,
            'Id_Akun'   => $token->Id_Akun,
            'Username'  => $token->Username,
            'Password'  => $token->Password
        ];
    }
}