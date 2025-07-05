<?php

declare(strict_types=1);

namespace App\Services\API;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Contracts\Services\API\CountryServiceReaderContract;

final class CountryServiceReader implements CountryServiceReaderContract
{
    /**
     * Fetch all countries from the external API.
     *
     * @return array
    */
    public function fetchAll(): array
    {
        $response = $this->getApiResponse();

        if (!$this->validateResponse($response)) {
            return ['error' => 'Failed to fetch countries from API, please check the connection or API status.'];
        }

        return $this->processCountries($response->json());
    }

    /**
     * Make the API request to fetch countries.
     *
     * @return Response
    */
    private function getApiResponse(): Response
    {
        $url = config('api.country_url');
        return Http::get($url);
    }

    /**
     * Validate the API response.
     *
     * @param Response $response
     * @return bool
    */
    private function validateResponse(Response $response): bool
    {
        if ($response->successful()) {
            return true;
        }

        Log::error('Failed to fetch countries from API.', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        return false;
    }

    /**
     * Process and filter the country data.
     *
     * @param array $countries
     * @return array
    */
    private function processCountries(array $countries): array
    {
        $result = [];

        foreach ($countries as $item) {
            if ($this->isValidCountry($item)) {
                $result[] = $this->transformCountry($item);
            }
        }

        return $result;
    }

    /**
     * Validate if a country record contains the necessary data.
     *
     * @param array $item
     * @return bool
    */
    private function isValidCountry(array $item): bool
    {
        return isset($item['name'], $item['alpha2Code'], $item['demonym']);
    }

    /**
     * Transform the country record into a standardized format.
     *
     * @param array $item
     * @return array
    */
    private function transformCountry(array $item): array
    {
        return [
            'name'        => $item['name'],
            'code'        => $item['alpha2Code'],
            'nationality' => $item['demonym'],
        ];
    }
}
