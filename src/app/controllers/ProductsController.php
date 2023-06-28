<?php

use Phalcon\Mvc\Controller;

session_start();
class ProductsController extends Controller
{
    public function indexAction()
    {
        echo "<h3>This is products page</h3>";
        die;
    }
}
