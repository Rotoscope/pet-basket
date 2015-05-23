<?php

namespace Core;

class Route {

    public static function execute() {
        $controller = Uri::controller();
        //var_dump($controller);
        if ($controller === false)
            $controller = 'PetBasket';
        //exit;
        $controllerClass = $controller . 'Controller';
        $req = APP_PATH . '/classes/controller/' . $controllerClass . '.php';
        //var_dump($req);
        //exit;
        require_once $req;
        $action = Uri::action();

        return $controllerClass::_call($action);
    }

}
