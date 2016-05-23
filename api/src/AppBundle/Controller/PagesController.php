<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PagesController extends Controller
{
    /**
     * @Rest\View
     */
    public function listAction()
    {
        return [
	        'success'	=> true,
	        'items'	=> [
		        0	=> [
			        'name'	=> 'vasya'
		        ]
	        ]
        ];
    }
    
    
    /**
     * @Rest\View
     */
    public function getAction($id)
    {
        return [
	        'success'	=> true,
	        'items'	=> [
		        0	=> [
			        'name'	=> 'vasya',
			        'id'	=> $id
		        ]
	        ]
        ];
    }
}
