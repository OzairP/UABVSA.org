<?php

namespace App\Http\Controllers;

use App\Models\Redirection;
use Illuminate\Support\Facades\Log;

class RedirectionController extends Controller
{

    public function redirect (Redirection $redirection)
    {
        // In case we fail to increment the click count for whatever reason
        // we want to continue the users redirection
        try {
            $redirection->click();
        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect($redirection->redirects_to, status:307);
    }

}
