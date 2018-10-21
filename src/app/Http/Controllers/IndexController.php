<?php

namespace App\Http\Controllers;

/**
 * Class IndexController
 *
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{

    public function index()
    {
        return app()->version();
    }

    public function error()
    {
        throw new \RuntimeException("Test");
    }
}
