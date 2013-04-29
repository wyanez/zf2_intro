<?php
namespace Album\Form;

use Zend\Form\Form;

class AlbumForm extends Form{
	public function __construct($name='album'){
		parent::__construct($name);

		$this->setAttribute('method','post');

		$this->add( array(
			'name' => 'id',
			'type' => 'Hidden'
		));

		$arr_names=array('title','artist');
		$arr_labels=array('Titulo','Artista');

		for($i=0; $i<length($arr_names);$i++){
			$this->add( array(
				'name' => $arr_names[$i],
				'type' => 'Text',
				'options' => array(
					'label' => $arr_labels[$i],
				), 
			));
		}

		$this->add( array(
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array(
					'value' => 'Aceptar',
					'id' => 'submitbutton',
				), 
		));


	}	
}
?>