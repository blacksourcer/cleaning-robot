<?php

namespace App\Http\Controllers;

/**
 * Class IndexController
 *
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * @return string
     */
    public function index()
    {
        return app()->version();
    }
}
