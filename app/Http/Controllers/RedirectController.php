<?php

namespace App\Http\Controllers;

use App\Services\RedirectService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public $redirectService;

    /**
     * RedirectController constructor.
     * @param RedirectService $redirectService
     */
    public function __construct(RedirectService $redirectService)
    {
        $this->redirectService = $redirectService;
    }

    public function redirect($firstPiece, $secondPiece)
    {
        $model = $this->redirectService->getRedirectModel($firstPiece . '/' . $secondPiece);
        return redirect()->away($model->url);
    }
}
