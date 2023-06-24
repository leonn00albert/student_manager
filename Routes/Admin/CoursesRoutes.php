<?php
namespace Routes\Admin;
class CoursesRoutes
{
    static function register($app,$controller)
    {
        $app->get("/admin/courses", $controller->showIndex);
        $app->post("/courses",$app->form->sanitize, $controller->create);
    }
}