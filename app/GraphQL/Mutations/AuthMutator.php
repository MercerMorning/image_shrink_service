<?php

namespace App\GraphQL\Mutations;

use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use \Facades\App\Http\Controllers\AuthController;

class AuthMutator
{

    public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
//        request()->request = $args;
//        return json_encode(request()->all());
        $graphRequest = Arr::only($args, ['email', 'password']);
//        request()->request = $credentials;
        return AuthController::login($graphRequest);
    }

    public function register($rootValue, $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
//        response('Hello World', 400);
//        request()->request = $args;
//        return json_encode(request()->all());
        $validator = Validator::make($args, [
            'email' => 'email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'bad', 400]);;
//                ->withErrors($validator)
//                ->withInput();
        }

        $graphRequest = Arr::only($args, ['email', 'password', 'name']);
//        request()->request = $credentials;
        return AuthController::registration($graphRequest);
    }
}
