<?php

declare(strict_types=1);


namespace libasynCurl\thread;


use pocketmine\utils\Internet;

class CurlGetTask extends CurlTask
{
    public function onRun(): void
    {
        $request = Internet::getURL($this->page, $this->timeout, $this->getHeaders(), $error);
        $this->setResult([$request, $error]);
    }
}