<?php

namespace App\Services;

use App\Helpers\GenegateShorterUrl;
use App\Models\UrlShortener;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UrlShortenerService
{
    private $urlShortenerModel;
    private $urlGenegate;

    /**
     * UrlShortenerService constructor.
     * @param UrlShortener $urlShortenerModel
     * @param GenegateShorterUrl $urlGenegate
     */
    public function __construct(UrlShortener $urlShortenerModel, GenegateShorterUrl $urlGenegate)
    {
        $this->urlShortenerModel = $urlShortenerModel;
        $this->urlGenegate = $urlGenegate;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getUrls(): LengthAwarePaginator
    {
        return $this->urlShortenerModel->orderByDesc('id')->paginate();
    }

    /**
     * @param string $url
     * @return UrlShortener
     */
    public function storeUrlShortener(string $url): UrlShortener
    {
        return $this->urlShortenerModel->create([
            'code' => $this->getUrlShortener(),
            'url' => $url
        ]);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $this->urlShortenerModel->findOrFail($id)->delete();
    }

    /**
     * @return string
     */
    private function getUrlShortener(): string
    {
        $i = 1;
        do {
            $code = $this->urlGenegate->generate($i);
            $i++;
        } while ($this->urlShortenerModel->where('code', $code)->exists());
        return $code;
    }

    private function cha($url)
    {
        $client = new Client();
        try {
            $response = $client->get($url);
        } catch (ClientException $exception) {
            return false;
        }
    }
}
