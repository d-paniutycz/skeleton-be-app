<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Test\Helper;

use RuntimeException;
use Stringable;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestRequestBuilder
{
    private string $method;

    private string $uri;

    private ?string $content = null;

    /** @var array<array-key, mixed> */
    private array $server = [];

    public function __construct(
        private readonly AbstractBrowser $browser,
    ) {
    }

    public function useGet(string $uri): self
    {
        $this->method = Request::METHOD_GET;
        $this->uri = $uri;

        return $this;
    }

    public function usePost(string $uri): self
    {
        $this->method = Request::METHOD_POST;
        $this->uri = $uri;

        return $this;
    }

    public function usePath(string $uri): self
    {
        $this->method = Request::METHOD_PATCH;
        $this->uri = $uri;

        return $this;
    }

    public function useDelete(string $uri): self
    {
        $this->method = Request::METHOD_DELETE;
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public function withContent(array $data): self
    {
        $content = json_encode($data);
        if (!is_string($content)) {
            throw new RuntimeException('Could not encode data.');
        }

        $this->content = $content;

        return $this;
    }

    public function withToken(Stringable|string $token): self
    {
        $this->server['HTTP_AUTHORIZATION'] = 'Bearer ' . $token;

        return $this;
    }

    public function getResponse(): Response
    {
        $this->browser->request(
            $this->method,
            $this->uri,
            server: $this->server,
            content: $this->content,
        );

        $response = $this->browser->getResponse();

        if (!$response instanceof Response) {
            throw new RuntimeException('Response has wrong type');
        }

        return $response;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getResponseContent(): array
    {
        $content = $this->getResponse()->getContent();
        if (false !== $content) {

            /** @var mixed */
            $data = json_decode($content, true);

            if (is_array($data)) {
                return $data;
            }
        }

        return [];
    }
}
