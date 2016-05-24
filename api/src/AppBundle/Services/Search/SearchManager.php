<?php
namespace AppBundle\Services\Search;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Search manager instance to manipulate with search
 * the search instance is pawerfull to ge remote data
 * from remote source
 *
 * @author Leshanu E
 * @package Services\Search
 */
class SearchManager 
{

	/**
	 * Provider search instance
	 * that provider indicate as what we must search
	 *
	 * @var SearchInterface $provider
	 */
	protected $provider;
	
	
	/**
	 * Request stack sended in this service
	 *
	 * @var RequestStack $requestStack
	 */
	protected $requestStack;
	
	/**
	 * Name of the searching engine
	 *
	 * @var String $search
	 */
	protected $search;
	
	
	/**
	 * Constructor of search service
	 * will be provide search to remote host	
	 *
	 * @param SearchInterface $provider Search provider instance, may be category or detail
	 * @param RequestStack $requestStack Request stack object
	 */
	public function __construct(SearchInterface $provider, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack->getCurrentRequest();
        
        $this->provider = $provider;
    }
    
    
    public function search($name = NULL)
    {
	    $this->provider->search($name);
    }
    
    public function collectData()
    {
	    $this->provider->collectData();
    }
	
}