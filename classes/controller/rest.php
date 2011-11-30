<?php defined('SYSPATH') or die('No direct script access.');

class Controller_REST extends Controller 
	implements REST_Content_JSON, REST_Content_XML, REST_Content_HTML {

	protected $_rest;
	
	public function before()
	{
		parent::before();
		$this->_rest = REST::instance($this)
                        ->override(TRUE)
                        ->execute();
	}
	
	public function action_json()
	{
		$model = $this->_rest->model();
		$this->response->body(json_encode($model->values()));
	}
	
	public function action_xml()
	{
		$model = $this->_rest->model();
		$xml = new SimpleXMLElement('<root/>');
		array_walk_recursive($model->values(), array ($xml, 'addChild'));
		$this->response->body($xml->asXML());
	}
	
	public function action_html()
	{
		$model = $this->_rest->model();
		$this->response->body('<pre>'.print_r($model->values(), TRUE).'</pre>');
	}

} // End REST
