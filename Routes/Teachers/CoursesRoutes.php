<?php
namespace Routes\Teachers;
class CoursesRoutes
{
    static function register($app,$controller)
    {
        $app->get("/teachers/courses", $controller->showIndex);
        $app->get("/teachers/courses/:id/edit", $controller->showEdit);
    
    }
}