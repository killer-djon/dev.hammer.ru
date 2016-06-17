<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Kohana_Cart extends Controller_Template
{
	
	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = FALSE;
	
	/**
	 * IOCart instance
	 * @var IOCart isntance of the IOCart abstract object
	 */
	protected $_cart = NULL;

	protected $_cartId = NULL;
	
	abstract public function action_index();
	
	
	/**
	 *
	 */
	public function action_add()
	{
		if( $product = Arr::extract($this->request->post(), array('id', 'article', 'qty', 'name', 'price')) )
		{
			if( empty($product['id']) )
			{
				throw new Kohana_Exception('ID of the product is empty');
			}
			
			if( empty($product['article']) )
			{
				throw new Kohana_Exception('Product item not have article, check please this product');
			}
			
			if( empty($product['qty']) || (int)$product['qty'] <= 0 )
			{
				throw new Kohana_Exception('Product count cant be less than 0');
			}
			
			
			$this->_add(
				(string)$product['id'],
				(string)$product['article'],
				(int)$product['qty'],
				trim($product['name']),
				sprintf('%01.2f', $product['price'])
			);
		}
	}
	
	/**
	 * Clear cart content
	 *
	 * @return array Empty array
	 */
	public function action_clear()
	{
		$this->_cart->clear();
		$this->_generate_response();
	}
	
	/**
	 * Remove item of the product from cart content
	 *
	 * @param string $id Represents string hash id of the MongoID object
	 *
	 * @return array $_content Return content of the all products
	 */
	public function action_delete()
	{
		if( $product = Arr::extract($this->request->post(), array('id')) )
		{
			if (!empty($product)) 
			{
				$this->_cart->removeProduct($product['id']);
				
			}
			$this->_generate_response();			
		}
	}
	
	
	public function action_content()
	{
		$this->_generate_response();
	}
	
	/**
	 * THis method will be add some item to shopping cart
	 *
	 * @param string $id Represents string hash id of the MongoID object
	 * @param string $article string article of added product
	 * @param int $qty Count of the added product items
	 * @param double $price if exists or null for empty price
	 *
	 * @return void
	 */
	protected function _add($id, $article, $qty, $name = NULL, $price = NULL)
	{
		
		$this->_cart->setProduct([
			'id'	=> $id,
			'article'	=> $article,
			'qty'	=> $qty,
			'name'	=> $name,
			'price'	=> $price
		]);
		
		$this->_generate_response();
			
	}
	
	/**
	 * Update some item from cart content
	 * this method must check cart content
	 * and if this product item was found then update them
	 * else add new item
	 *
	 * @param string $id Represents string hash id of the MongoID object
	 * @param string $article string article of added product
	 * @param int $qty Count of the added product items
	 * @param double $price if exists or null for empty price
	 *
	 * @return array $_content Return content of the all products
	 */
	public function action_update()
	{
		$updateData = $this->request->post();
		if( !empty($updateData) )
		{
			
			foreach( $updateData as $key => $data )
			{
				$this->_cart->updateProduct($data);
			}
		}
		
		$this->_generate_response();
	}
	
	
	/**
	 * Generate response of the cart action
	 *
	 * @return void|array If request is ajax the nothing return else array cart content
	 */
	protected function _generate_response()
	{
		if ($this->request->is_ajax())
		{
			//$this->response->body(json_encode($this->_cart->getProductContent());
			$this->template = View::factory($this->template);
			$this->template->cart = $this->_cart->getProductContent();
			
			$this->response
				->headers('Content-Type', 'application/json')
				->body(json_encode([
					'success'	=> true,
					'result'	=> $this->template->render(),
					'cart_data'	=> $this->_cart->getProductContent()
				]));
		}
		else
		{
			return $this->_content;
		}
	}
	
	
	
	
	
	
	
	
	/**
	 * If cart is not empty 
	 * user can checkout all products
	 *
	 * @return array Empty array
	 */
	public function checkout($cartId)
	{
		$this->_cartId = $cartId;
		$this->_cart->setCartId($cartId);

		return $this;
	}
}