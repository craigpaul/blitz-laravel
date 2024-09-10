<?php

namespace CraigPaul\Blitz\Testing;

use function array_filter;
use function array_is_list;
use function array_map;
use function base64_encode;
use function count;
use CraigPaul\Blitz\Exceptions\UnsupportedAuthenticationGuardException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

abstract class TestCase
{
    /**
     * The buckets that will be using for grouping response times by Blitz.
     *
     * @var array|null
     */
    protected ?array $buckets = null;

    /**
     * Additional cookies for the request.
     *
     * @var array
     */
    protected array $defaultCookies = [];

    /**
     * Additional headers for the request.
     *
     * @var array
     */
    protected array $defaultHeaders = [];

    /**
     * Indicates whether cookies should be encrypted.
     *
     * @var bool
     */
    protected bool $encryptCookies = true;

    /**
     * The targets that will be attacked by Blitz.
     *
     * @var array
     */
    protected array $targets = [];

    /**
     * Additional cookies will not be encrypted for the request.
     *
     * @var array
     */
    protected array $unencryptedCookies = [];

    /**
     * Indicated whether JSON requests should be performed "with credentials" (cookies).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/withCredentials
     *
     * @var bool
     */
    protected bool $withCredentials = false;

    /**
     * Define additional headers to be sent with the request.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function withHeaders(array $headers): self
    {
        $this->defaultHeaders = [...$this->defaultHeaders, ...$headers];

        return $this;
    }

    /**
     * Add a header to be sent with the request.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function withHeader(string $name, string $value): self
    {
        $this->defaultHeaders[$name] = $value;

        return $this;
    }

    /**
     * Add an authorization token for the request.
     *
     * @param string $token
     * @param string $type
     *
     * @return $this
     */
    public function withToken(string $token, string $type = 'Bearer'): self
    {
        return $this->withHeader('Authorization', $type . ' ' . $token);
    }

    /**
     * Add a basic authentication header to the request with the given credentials.
     *
     * @param string $username
     * @param string $password
     *
     * @return $this
     */
    public function withBasicAuth(string $username, string $password): self
    {
        return $this->withToken(base64_encode("{$username}:{$password}"), 'Basic');
    }

    /**
     * Remove the authorization token from the request.
     *
     * @return $this
     */
    public function withoutToken(): self
    {
        unset($this->defaultHeaders['Authorization']);

        return $this;
    }

    /**
     * Flush all the configured headers.
     *
     * @return $this
     */
    public function flushHeaders(): self
    {
        $this->defaultHeaders = [];

        return $this;
    }

    /**
     * Define additional cookies to be sent with the request.
     *
     * @param array $cookies
     *
     * @return $this
     */
    public function withCookies(array $cookies): self
    {
        $this->defaultCookies = [...$this->defaultCookies, ...$cookies];

        return $this;
    }

    /**
     * Add a cookie to be sent with the request.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function withCookie(string $name, string $value): self
    {
        $this->defaultCookies[$name] = $value;

        return $this;
    }

    /**
     * Define additional cookies will not be encrypted before sending with the request.
     *
     * @param array $cookies
     *
     * @return $this
     */
    public function withUnencryptedCookies(array $cookies): self
    {
        $this->unencryptedCookies = [...$this->unencryptedCookies, ...$cookies];

        return $this;
    }

    /**
     * Add a cookie will not be encrypted before sending with the request.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function withUnencryptedCookie(string $name, string $value): self
    {
        $this->unencryptedCookies[$name] = $value;

        return $this;
    }

    /**
     * Include cookies and authorization headers for JSON requests.
     *
     * @return $this
     */
    public function withCredentials(): self
    {
        $this->withCredentials = true;

        return $this;
    }

    /**
     * Disable automatic encryption of cookie values.
     *
     * @return $this
     */
    public function disableCookieEncryption(): self
    {
        $this->encryptCookies = false;

        return $this;
    }

    /**
     * Set the currently logged in user for the request.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param null|string $guard
     *
     * @return $this
     *
     * @throws \CraigPaul\Blitz\Exceptions\UnsupportedAuthenticationGuardException
     */
    public function actingAs(Authenticatable $user, ?string $guard = null)
    {
        $guard = $guard ?: Config::get('auth.defaults.guard');

        Auth::guard($guard)->login($user);

        Session::save();

        match (Config::get('auth.guards.' . $guard . '.driver')) {
            'session' => $this->withCookie(Config::get('session.cookie'), Session::getId()),
            default => throw new UnsupportedAuthenticationGuardException($guard),
        };

        return $this;
    }

    /**
     * Include histogram buckets for grouping response times.
     *
     * @param array $buckets
     *
     * @return $this
     */
    public function withBuckets(array $buckets): self
    {
        $pattern = '/^(\d+)(ns|us|ms|s|m|h)$/';

        foreach ($buckets as $bucket) {
            if (preg_match($pattern, $bucket) === false) {
                throw new InvalidArgumentException("Invalid bucket value [$bucket] provided. This should match the following format: 100ms. Valid time units are 'ns', 'us', 'ms', 's', 'm', and 'h'.");
            }
        }

        $this->buckets = $buckets;

        return $this;
    }

    /**
     * Visit the given URI with a GET request.
     *
     * @param string $uri
     * @param array $headers
     *
     * @return void
     */
    public function get(string $uri, array $headers = []): void
    {
        $cookies = $this->prepareCookiesForRequest();

        $this->call('GET', $uri, [], $cookies, $headers);
    }

    /**
     * Visit the given URI with a GET request, expecting a JSON response.
     *
     * @param string $uri
     * @param array $headers
     *
     * @return void
     */
    public function getJson(string $uri, array $headers = []): void
    {
        $this->json('GET', $uri, headers: $headers);
    }

    /**
     * Visit the given URI with a POST request.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function post(string $uri, array $data = [], array $headers = []): void
    {
        $cookies = $this->prepareCookiesForRequest();

        $this->call('POST', $uri, $data, $cookies, $headers);
    }

    /**
     * Visit the given URI with a POST request, expecting a JSON response.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function postJson(string $uri, array $data = [], array $headers = []): void
    {
        $this->json('POST', $uri, $data, $headers);
    }

    /**
     * Visit the given URI with a PUT request.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function put(string $uri, array $data = [], array $headers = []): void
    {
        $cookies = $this->prepareCookiesForRequest();

        $this->call('PUT', $uri, $data, $cookies, $headers);
    }

    /**
     * Visit the given URI with a PUT request, expecting a JSON response.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function putJson(string $uri, array $data = [], array $headers = []): void
    {
        $this->json('PUT', $uri, $data, $headers);
    }

    /**
     * Visit the given URI with a PATCH request.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function patch(string $uri, array $data = [], array $headers = []): void
    {
        $cookies = $this->prepareCookiesForRequest();

        $this->call('PATCH', $uri, $data, $cookies, $headers);
    }

    /**
     * Visit the given URI with a PATCH request, expecting a JSON response.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function patchJson(string $uri, array $data = [], array $headers = []): void
    {
        $this->json('PATCH', $uri, $data, $headers);
    }

    /**
     * Visit the given URI with a DELETE request.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function delete(string $uri, array $data = [], array $headers = []): void
    {
        $cookies = $this->prepareCookiesForRequest();

        $this->call('DELETE', $uri, $data, $cookies, $headers);
    }

    /**
     * Visit the given URI with a DELETE request, expecting a JSON response.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function deleteJson(string $uri, array $data = [], array $headers = []): void
    {
        $this->json('DELETE', $uri, $data, $headers);
    }

    /**
     * Call the given URI with a JSON request.
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function json(string $method, string $uri, array $data = [], array $headers = []): void
    {
        $headers = [
            ...$headers,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->call($method, $uri, $data, $this->prepareCookiesForJsonRequest(), $headers);
    }

    /**
     * Call the given URI.
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $cookies
     * @param array $headers
     *
     * @return void
     */
    public function call(string $method, string $uri, array $data = [], array $cookies = [], array $headers = []): void
    {
        $headers = [
            ...$this->defaultHeaders,
            ...$headers,
        ];

        if (count($cookies) > 0) {
            $headers['Cookie'] = Collection::make($cookies)->map(fn ($value, $key) => $key . '=' . $value)->implode('; ');
        }

        $this->targets[] = array_filter([
            'body' => array_is_list($data) && count($data) === 0 ? null : $data,
            'headers' => array_is_list($headers) && count($headers) === 0 ? null : array_map(fn ($header) => Arr::wrap($header), $headers),
            'method' => $method,
            'url' => $uri,
        ]);
    }

    /**
     * Retrieve the generated load test buckets.
     *
     * @return array|null
     */
    public function getBuckets(): ?array
    {
        return $this->buckets;
    }

    /**
     * Retrieve the generated load test targets.
     *
     * @return array
     */
    public function getTargets(): array
    {
        return $this->targets;
    }

    /**
     * If enabled, encrypt cookie values for request.
     *
     * @return array
     */
    protected function prepareCookiesForRequest(): array
    {
        if (! $this->encryptCookies) {
            return [...$this->defaultCookies, ...$this->unencryptedCookies];
        }

        return Collection::make($this->defaultCookies)->map(function ($value, $key) {
            return Crypt::encrypt(CookieValuePrefix::create($key, Crypt::getKey()) . $value, false);
        })->merge($this->unencryptedCookies)->all();
    }

    /**
     * If enabled, add cookies for JSON requests.
     *
     * @return array
     */
    protected function prepareCookiesForJsonRequest(): array
    {
        return $this->withCredentials ? $this->prepareCookiesForRequest() : [];
    }
}
