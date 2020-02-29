<?php

namespace App\Services;

use App\Models\UrlShortener;

class RedirectService
{
    private $urlShortenerModel;

    /**
     * RedirectService constructor.
     * @param UrlShortener $urlShortenerModel
     */
    public function __construct(UrlShortener $urlShortenerModel)
    {
        $this->urlShortenerModel = $urlShortenerModel;
    }

    /**
     * @param string $code
     * @return UrlShortener
     */
    public function getRedirectModel(string $code): UrlShortener
    {
        $urlModel = $this->urlShortenerModel->where('code', $code)->first();
        if (empty($urlModel)) {
            abort(404);
        }
        $this->urlShortenerModel->where('id', $urlModel->id)->increment('click_count');
        return $urlModel;
    }
}
