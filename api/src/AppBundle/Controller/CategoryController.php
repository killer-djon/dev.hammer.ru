<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Services\Search\SearchManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Controller to find|load category from DB or from remote host	
 *
 * @author Leshanu E
 * @package AppBundle
 */
class CategoryController extends Controller
{
	/**
     * @Rest\View
     *
     * @param  String $name Name of the searching engine
     */
	public function listAction( $name, Request $request )
	{
		$category = $this->get('app.category_search');
		
		$requestStack = new RequestStack;
		$requestStack->push($request);
		
		$searchManager = new SearchManager($category, $requestStack);
		
		$searchManager->search($name);
		$searchManager->collectData();
		
		return [];
	}
	
	
}