<?php 
// require_once('/database.php');
    function autoload_class($class_name) {
        $directories = array(
            'classes/',
            'classes/controllers/',
            'classes/models/'
        );
        foreach ($directories as $directory) {
            $filename = $directory . $class_name . '.php';
            if (is_file($filename)) {
                require($filename);
                break;
            }
        }
    }

    spl_autoload_register('autoload_class');
    $request = new Request();
    if (isset($_SERVER['PATH_INFO'])) {
        $request->url_elements = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    }
    
    $request->method = strtoupper($_SERVER['REQUEST_METHOD']);
    switch ($request->method) {
        case 'GET':
            $request->parameters = $_GET;
        break;
        case 'POST':
            $request->parameters = json_decode(file_get_contents('php://input'), true);;
        break;
        case 'PUT':
            parse_str(file_get_contents('php://input'), $request->parameters);
        break;
    }

    if (!empty($request->url_elements)) {
        $action =  $request->url_elements[1];
        $controller_name = ucfirst($request->url_elements[0]) . 'Controller';
        if (class_exists($controller_name)) {
            $controller = new $controller_name;
            $action_name = strtolower($action);
            $response_str = call_user_func_array(array($controller, $action_name), array($request));
        }else {
            header('HTTP/1.1 404 Not Found');
            $response_str = 'Unknown request: ' . $request->url_elements[0];
        }
    }else {
        $response_str = 'Unknown request';
    }

    /**
     * Send the response to the client.
     */
    $response_obj = Response::create($response_str, $_SERVER['HTTP_ACCEPT']);
    echo $response_obj->render();

?>