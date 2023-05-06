<?php

namespace Pschur\Assets;

use Pschur\Assets\Support\CSS;
use Pschur\Assets\Support\JS;

class Asset
{
    private static array $assets = ['js' => [], 'css' => []];

    private static string $assetUrl = '';

    private static string $assetCache = '';

    public static bool $auto_optimize = false;

    public static function js(string $content){
        self::$assets['js'][] = $content;
    }

    public static function css(string $content){
        self::$assets['css'][] = $content;
    }

    /**
     * @param string $assetUrl
     */
    public static function setAssetUrl(string $assetUrl): void
    {
        self::$assetUrl = $assetUrl;
    }

    /**
     * @param string $assetCache
     */
    public static function setAssetCache(string $assetCache): void
    {
        self::$assetCache = ltrim($assetCache, '/');
    }

    public static function cache(){
        if (!file_exists(self::path())) mkdir(self::path());

        $key = md5($_SERVER['REQUEST_URI']);
        $build = false;

        self::$assets['key'] = $key;

        if (file_exists(self::path($key))){
            $loader = json_decode(file_get_contents(self::path($key)), true);

            if ($loader != self::$assets && !isset($loader['optimized'])) $build = true;
        } else {
            $build = true;
        }

        if ($build) {
            file_put_contents(self::path($key), json_encode(self::$assets));
        }

        return [
            'css' => self::$assetUrl.'?'.http_build_query(['key' => $key, 'type' => 'css']),
            'js' => self::$assetUrl.'?'.http_build_query(['key' => $key, 'type' => 'js'])
        ];
    }

    public static function getAsset(): bool|string
    {
        if (!isset($_GET['key']) && !isset($_GET['type'])){
            throw new \ErrorException('Cannot find key or type in the $_GET variable');
        }

        if (!in_array($_GET['type'], ['css', 'js'])) throw new \ErrorException(sprintf("The file type %s is not known", $_GET['type']));

        if (!file_exists(self::path($_GET['key']))) throw new \ErrorException("The style and scripts for this key are not builded now.");


        $mime = [
            'css' => 'text/css',
            'js' => 'text/javascript'
        ];

        header('Content-Type: '.$mime[$_GET['type']]);

        if (file_exists(self::path($_GET['key'].'.'.$_GET['type']))){
            return file_get_contents(self::path($_GET['key'].'.'.$_GET['type']));
        }

        if (self::$auto_optimize){
            self::optimize_asset(self::path($_GET['key']));
        }

        $loader = json_decode(file_get_contents(self::path($_GET['key'])), true);

        if ($_GET['type'] == 'css'){
            $css = new CSS();
            $css->add($loader['css']);
            $content = $css->minify();
        }
        if ($_GET['type'] == 'js'){
            $js = new JS();
            $js->add($loader['js']);
            $content = $js->minify();
        }

        return $content;
    }

    public static function optimize(){
        $files = glob(self::path('*'));

        foreach ($files as $file){
            self::optimize_asset($file);
        }
    }

    private static function path(string $path = null): string
    {
        $path = trim($path ?? '', '/');
        return self::$assetCache.'/'.$path;
    }

    private static function optimize_asset(mixed $file)
    {
        $asset = json_decode(file_get_contents($file), true);
        $asset['optimized'] = true;

        $css = new CSS($asset['css']);
        $js = new JS($asset['js']);

        $css->minify(self::path($asset['key'].'.css'));
        $js->minify(self::path($asset['key'].'.js'));
    }
}