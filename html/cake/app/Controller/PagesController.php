<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}

	public function category($category) {
		if ($this->request->data('lat') && $this->request->data('long')) {
			$lat = (float) $this->request->data('lat');
			$long = (float) $this->request->data('long');
			$this->set(compact('category', 'lat', 'long'));	
		} else {
			$this->set('category', $category);
		}
	}
	
	public function categoryByLikes() {
		$this->layout = 'ajax';
		if ($this->request->data('category')) {
			$category = $this->request->data('category');			
			$this->set(compact('category'));
		} else {
			echo 'Category required';
			exit;
		}
	}
	
	public function categoryByLocation() {
		$this->layout = 'ajax';
		if ($this->request->data('category') && $this->request->data('lat') && $this->request->data('long')) {
			$category = $this->request->data('category');
			$lat = (float) $this->request->data('lat');
			$long = (float) $this->request->data('long');
			
			$this->set(compact('category', 'lat', 'long'));
		} else {
			echo 'Location required';
			exit;
		}
	}

	public function like() {
		$eatdrink_config = Configure :: read('connection');
		$apiKey = $eatdrink_config['apiKey'];

		$this->autoRender = false;
		$id = $this->request->data('id');
		$likes = $this->request->data('likes');

		$urlCall = "https://api.mongolab.com/api/1/databases/eatdrinksea/collections/Spots/".$id."?apiKey=".$apiKey."";
		
		$data = array("\$set" => array("likes" => $likes));

		$datajson = json_encode($data);

		$HttpSocket = new HttpSocket();			

		$body = $HttpSocket->request(array(
			'method' => 'PUT',
			'uri' => $urlCall,
			'header' => array('Content-Type' => 'application/json'),
			'body' => $datajson
		));
	}
}
