<?php
namespace Routes\Teachers;
class ClassroomsRoutes
{
    static function register($app,$controller)
    {
        $app->get("/teachers/classrooms", $controller->showIndex);
        $app->get("/teachers/classrooms/:id", $controller->show);
        $app->get("/teachers/classrooms/:id/edit", $controller->showEdit);
        $app->get("/teachers/classrooms/:id/report", $controller->showReport);
        $app->put("/classrooms/:id", $app->form->sanitize, $controller->update);
    }
}

