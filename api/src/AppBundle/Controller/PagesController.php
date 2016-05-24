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
    	$repository = $this->get('doctrine_mongodb')
		    ->getManager()
		    ->getRepository('StorageBundle:Pages');
		
		$pages = $repository->findAll();
		
		if (!$pages) 
		{
	        throw $this->createNotFoundException('No pages found');
	    }
	    
		return [
			'success'	=> true,
			'items'	=> $pages,
			'count'	=> count($pages)
		];
    }
    
    
    /**
     * @Rest\View
     */
    public function getAction($id)
    {
        $repository = $this->get('doctrine_mongodb')
		    ->getManager()
		    ->getRepository('StorageBundle:Pages');
		    
		
		$page = $repository->find($id);    
		
		if( !$page )
		{
			throw $this->createNotFoundException('Page not found with id: '.$id);
		}
		
		return [
			'success'	=> true,
			'items'	=> $page,
		];
    }
}
