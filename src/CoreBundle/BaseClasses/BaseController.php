<?php

namespace CoreBundle\BaseClasses;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function buildResponse($data, int $statusCode, $isError = false)
    {

    }
}