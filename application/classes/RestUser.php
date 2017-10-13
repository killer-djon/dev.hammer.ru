<?php defined('SYSPATH') or die('No direct script access.');

class RestUser extends Kohana_RestUser {
    /**
     * A mock loading of a user object.
     */
    protected function _find()
    {
        switch ($this->_api_key)
        {
            case 'aGFtbWVyOm55RkZxdjIwMTU=':
                $this->_id = 1;
                $this->_secret_key = 'hammer_admin';
                $this->_roles = array('developer', 'manager');
            default:
                break;
        }
    }
} // END