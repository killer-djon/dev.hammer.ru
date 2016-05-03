<?php defined('SYSPATH') OR die('No direct script access.');
	
/**
 * Abstract class to resolve all shopping cart methods
 *
 * @author Leshanu E
 */
abstract class Kohana_IOCart
{
	
	/**
	 * Errors array when 
	 * @var array $_content
	 */
	protected $_errors = [];
	
	
	/**
	 * Cart content var
	 * @var array $_content
	 */
	protected $_content = NULL;
	
	/**
	 * Session instance system
	 * @var Session $_session
	 */
	protected $_session = NULL;
	
	/**
	 * Config array from file config
	 * @var array $_config
	 */
	protected $_config = [];
	
	
	public function setProduct(array $product)
	{
		$this->_set_product($product);
	}
	
	public function removeProduct($id)
	{
		$product = $this->_get_product($id);
		
		if( isset($this->_content['products'][$product['id']]) )
		{
			unset($this->_content['products'][$product['id']]);	
		}
		
		return $this->_save();
	}

	public function getProductContent()
	{
		return $this->_content;
	}

	
	// Calc & get discount
	protected function _get_discount()
	{
		// TODO: 
	}
	
	public function updateProduct(array $updateProduct)
	{
		$product = $this->_get_product($updateProduct['id']);
		
		if( !is_null($product) )
		{
			$this->_content['products'][$product['id']]['qty'] = $updateProduct['qty'];
		}
		
		return $this->_save();
	}

	// Set new total values
	protected function _set_total()
	{
		$this->_content['total'] = array('price' => 0, 'count' => 0, 'discount' => 0);
		
		if ( ! empty($this->_content['products']))
		{
			foreach ($this->_content['products'] as $product)
			{
				$this->_content['total']['price']  += $product['price'] * $product['qty'];
				$this->_content['total']['count'] += $product['qty'];
			}
			
			// Discount
			$this->_content['total']['discount'] = $this->_get_discount();
			$this->_content['total']['price'] -= $this->_content['total']['discount'];
		}
		
		return $this;
	}

	/**
	 * Set single product to session data
	 *
	 * @return array Return single product data from cart content
	 */
	protected function _set_product(array $product)
	{
		$qty = max(1, $product['qty']);
		$id = $this->_get_product($product['id']);
		
		if (isset($this->_content['products'][$product['id']]))
		{
			$this->_content['products'][$product['id']]['qty'] += $qty;
		}
		else
		{
			//$product['qty'] = $qty;
			$this->_content['products'][$product['id']] = $product;
		}
		
		return $this->_save();
	}
	
	/**
	 * Get single product item from cart content
	 * in this data key of the array is the id of product
	 *
	 * @return array Return single product data from cart content
	 */
	protected function _get_product($id)
	{
		$sessionData = $this->_session->get($this->_config['session']['key']);
		
		return ( !isset($sessionData['products'][$id]) ? NULL : $sessionData['products'][$id] );
	}
	
	public function clear()
	{
		$data =& $this->_session->as_array();
		if( !isset( $data[$this->_config['session']['key']] ) )
		{
			return NULL;
		}else
		{
			return $this->_session->destroy();
		}
		
	}
	
	/**
	 * Get all cart content
	 *
	 * @return array Return cart content
	 */
	protected function _get_content()
	{
		$data = $this->_session->get($this->_config['session']['key']);
		
		return (is_null($data) ? FALSE : NULL);
	}
	
	/**
	 * Must be save cart content to base
	 * and send Email to client and admin
	 *
	 * @return void
	 */
	protected function _save()
	{
		// recalc result
		$this->_set_total();
		// save in session
		$this->_session->set(
			$this->_config['session']['key'],
			$this->_content,
			$this->_config['session']['lifetime']
		);
		return $this;
	}
}