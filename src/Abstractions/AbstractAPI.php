<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Exception;

/**
 * The classes that extends this
 * will implement a API endpoint.
 */
abstract class AbstractAPI
{
    protected string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function requestGET(): array
    {
        $response = wp_remote_get($this->url);
        return $this->parseResponse($response);
    }

    protected function parseResponse($response): array //phpcs:ignore
    {
        if (is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }

        $code = wp_remote_retrieve_response_code($response);

        if (is_string($code)) {
            throw new Exception('Incorrect parameter passed to wp_remote_retrieve_response_code');
        }

        if ($this->treatResponseCode($code)) {
            $body = wp_remote_retrieve_body($response);
            return $this->formatBody($body);
        }

        return [];
    }

    abstract protected function treatResponseCode(int $code): bool;

    abstract protected function formatBody(string $body): array;
}
