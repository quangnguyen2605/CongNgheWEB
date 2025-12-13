<?php
class HomeController
{
    public function index()
    {
        $pageTitle = 'Online Course - Home';
        require __DIR__ . '/../views/home/index.php';
    }
}
