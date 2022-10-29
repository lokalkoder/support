<?php

namespace Lokalkoder\Support\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait RequestCacheId
{
    /**
     * @param Request $request
     * @return string
     */
    public function getCacheId(string $name, Request $request): string
    {
        $inputId = preg_replace('/[^A-Za-z0-9\-]/', '', json_encode(array_values($request->input())));

        return $name . Auth::id() . $inputId;
    }
}
