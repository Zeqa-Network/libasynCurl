<?php

declare(strict_types=1);


namespace libasynCurl\thread;


use Closure;
use pocketmine\utils\Internet;
use pocketmine\utils\InternetException;
use function is_array;
use function json_encode;

class CurlCustomTask extends CurlTask
{
    /** @var string */
    protected string $method;
    /** @var string */
    protected string $args;

    public function __construct(string $page, string $method, array|string $args, int $timeout, array $headers, ?Closure $closure = null)
    {
        $this->method = $method;
        if (is_array($args)) {
            $this->args = json_encode($args, JSON_THROW_ON_ERROR);
        } else {
            $this->args = $args;
        }

        parent::__construct($page, $timeout, $headers, $closure);
    }

    public function onRun(): void
    {
        try {
            $result = Internet::simpleCurl($this->page, $this->timeout, $this->getHeaders(), [
                CURLOPT_CUSTOMREQUEST => $this->method,
                CURLOPT_POSTFIELDS => $this->args,
            ]);
            $this->setResult([$result, null]);
        } catch (InternetException $e) {
            $this->setResult([null, $e->getMessage()]);
        }
    }
}
