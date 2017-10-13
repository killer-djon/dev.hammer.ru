<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * An example REST model
 *
 * @package  RESTfulAPI
 * @category Model
 * @author   Alon Pe'er
 */
class Model_AuthUser extends Model_RestAPI {

    public function get($params)
    {
        // Process the request and fetch objects.
        // Returning a mock object.
        return array(
            'admins' => array(
                array('id' => 1, 'name' => 'hammer'),
            ),
        );
    }
}