<?php

namespace Pschur\Assets\Support;

use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

enum AssetTypes
{
    case SCRIPT;
    case STYLE;

    public function process(CSS $css, JS $js){
        return match($this){
            self::SCRIPT => $js,
            self::STYLE => $css,
        };
    }
}
