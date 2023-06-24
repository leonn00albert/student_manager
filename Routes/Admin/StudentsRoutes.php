<?php
namespace Routes\Admin;
class StudentsRoutes
{
    static function register($app,$controller)
    {
        $app->get("/admin/students", $controller->showIndex);
    }
}