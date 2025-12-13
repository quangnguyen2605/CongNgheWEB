<?php
class Config
{
    // Define base path for the application
    public static function getBasePath()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/');
        return "$protocol://$host$path";
    }
    
    // Define web root for assets
    public static function getWebRoot()
    {
        return dirname($_SERVER['PHP_SELF']);
    }
}
?>
