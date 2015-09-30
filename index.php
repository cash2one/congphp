<?php
define("_VERSION_",'0.0.1');
require "lib/application.class.php";

//$app = new Application;
//$app->run();

$uri    =   explode( '/', $_SERVER['REQUEST_URI'] );

array_shift($uri);
$class  = strtolower(array_shift($uri));
$method = strtolower(array_shift($uri));
$var    = strtolower(array_shift($uri));

$classfile=BASEPATH."controller/".$class.'.php';
if (file_exists($classfile))
{
    require_once $classfile;
    if (class_exists($class))
    {
        $clsHandler = new $class();
        if (method_exists($class, $method))
        {
            $clsHandler::$method($var);
        }
        else if( $method!='' )
        {
            exit( "<h1>$class.php: $class::$method Not Found</h1>");
        }
    }
    else
    {
        exit( "<h1>$class.php: $class Not Found</h1>" );
    }
}
else
{
    switch($class)
    {
        case '':
            echo "<h1>this is default page!</h1>";
            break;
        default:
            exit( "<h1>$class.php Not Found</h1>");
    }
}
?>