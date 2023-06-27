<?php
namespace Routes\Students;
class ModulesRoutes
{
    static function register($app,$controller)
    {
        $app->get("/students/modules/:id", $controller->show);
       

    }
}

