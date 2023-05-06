<?php

namespace Pschur\Assets\Support;

class JS extends \MatthiasMullie\Minify\JS
{
    public function getData(): array
    {
        return $this->data;
    }
}