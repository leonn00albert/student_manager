<?php
namespace Routes\Teachers;
class GradesRoutes
{
    static function register($app,$controller)
    {
        
        $app->get("/teachers/grades/:id", $controller->show);
        $app->put("/grades/:id",$app->form->sanitize, $controller->showIndex);

    }
}

