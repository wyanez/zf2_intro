<?php
	namespace Album\Model;

	class Album{
		public $id;
		public $title;
		public $artist;

		public function exchangeArray($data){
			$this->id = (isset($data['id'])) ? $data['id'] : null; 
			$this->title = (isset($data['title'])) ? $data['title'] : null; 
			$this->artist = (isset($data['artist'])) ? $data['artist'] : null; 
		}
		
		//requerido por el Hydrator: Zend\Stdlib\Hydrator\ArraySerializable
		public function getArrayCopy(){
			return get_object_vars($this);
		}	
	}
?>