<?php

namespace Pschur\Assets\Support;

class CSS extends \MatthiasMullie\Minify\CSS
{
    public function getData(): array
    {
        return $this->data;
    }

    public function add($data)
    {
        if (is_array($data)){
            foreach ($data as $item){
                $this->add($item);
            }

            return null;
        }

//        if (str_contains($data, 'http')) {
//            return $this->add(file_get_contents($data));
//        }

        return parent::add($data);
    }
}