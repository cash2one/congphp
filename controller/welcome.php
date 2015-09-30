<?php
/**
 * Created by PhpStorm.
 * User: HBS
 * Date: 15-9-30
 * Time: 下午5:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class welcome {
    public function index()
    {
        $this->load->view('welcome_message');
    }
}
