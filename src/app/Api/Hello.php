<?php
namespace App\Api;

use PhalApi\Api;
/**
 * HEllo
 */

class Hello extends Api {
    /**
	 * Hello
     * @desc hello
	 */
    public function hello() {
        return array('title' => 'Hello World!');
    }
}

