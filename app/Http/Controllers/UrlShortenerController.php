<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortenerRequest;
use App\Services\UrlShortenerService;
use Illuminate\Http\Request;

class UrlShortenerController extends Controller
{
    private $urlShortenerService;

    /**
     * UrlShortenerController constructor.
     * @param $urlShortenerService
     */
    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('url-shortener.index')->with([
            'urlShorteners' => $this->urlShortenerService->getUrls()
        ]);
    }

    /**
     * @param UrlShortenerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UrlShortenerRequest $request)
    {
        $result = $this->urlShortenerService->storeUrlShortener($request->post('url'));
        $request->session()->flash('generate_url', $result->id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->urlShortenerService->destroy($id);
        request()->session()->flash('destroy', 'Url removed');
        return redirect()->back();
    }
}
