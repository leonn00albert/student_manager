<?php
namespace Routes\Students;
class ClassroomsRoutes
{
    static function register($app,$controller)
    {
        
        $app->get("/students/classrooms/:id", $controller->show);
        $app->get("/students/classrooms", $controller->showIndex);

    }
}

