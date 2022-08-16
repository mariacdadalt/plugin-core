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
    protected string $cache;
    protected array $args;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function changeArgs(array $args): void
    {
        $this->args = $args;
    }

    public function requestGET(array $args = []): array
    {
        if ($this->hasCache()) {
            return $this->formatBody($this->cache);
        }

        $response = wp_remote_get($this->parseUrl(), $args);
        return $this->parseResponse($response);
    }

    protected function parseUrl(): string
    {
        return $this->url;
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
            set_transient($this->cacheKey(), $body, 300);
            return $this->formatBody($body);
        }

        return [];
    }

    /**
     * Checks if a transient exists
     * @return bool
     */
    protected function hasCache(): bool
    {
        $transient = get_transient($this->cacheKey());
        if ($transient === false) {
            return false;
        }

        $this->cache = $transient;
        return true;
    }

    abstract protected function treatResponseCode(int $code): bool;

    abstract protected function formatBody(string $body): array;

    abstract protected function cacheKey(): string;
}
