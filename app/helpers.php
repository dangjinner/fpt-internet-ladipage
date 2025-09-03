<?php

if (!function_exists('v')) {
    /**
     * Sinh URL asset kèm query string version
     * - Local: lấy theo filemtime
     * - Production (hoặc env khác): lấy theo config('app.version')
     *
     * @param string $path
     * @return string
     */
    function v(string $path): string
    {
        // Nếu path là URL tuyệt đối (http/https)
        if (preg_match('/^https?:\/\//', $path)) {
            $version = app()->environment('local')
                ? time()
                : config('app.version');

            return $path . '?v=' . $version;
        }

        $url = asset($path);

        if (app()->environment('local')) {
            $fullPath = public_path($path);
            $version  = file_exists($fullPath) ? filemtime($fullPath) : time();
        } else {
            $version = config('app.version');
        }

        return $url . '?v=' . $version;
    }
}


if (!function_exists('site_config')) {
    /**
     * Lấy thông tin cấu hình từ file JSON (1 site duy nhất)
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function site_config(string $key, $default = '')
    {
        static $siteConfig = null;

        if ($siteConfig === null) {
            $file = storage_path("app/config.json");

            if (file_exists($file)) {
                $siteConfig = json_decode(file_get_contents($file), true);
            } else {
                $siteConfig = [];
            }
        }

        return $siteConfig[$key] ?? $default;
    }
}
