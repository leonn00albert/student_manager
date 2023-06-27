<?php
namespace Routes\Teachers;
class ClassroomsRoutes
{
    static function register($app,$controller)
    {
        
        $app->get("/teachers/classrooms/:id", $controller->show);
        $app->get("/teachers/classrooms", $controller->showIndex);

    }
}

