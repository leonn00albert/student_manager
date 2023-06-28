<?php
namespace Routes\Students;
class CoursesRoutes
{
    static function register($app,$controller)
    {
        
        $app->get("/students/courses/:id", $controller->show);
        $app->get("/students/courses", $controller->showIndex);

    }
}

