<?php
namespace Album\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\inputFilter;
use Zend\InputFilter\inputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AlbumFiter implements InputFilterAwareInterface{
	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter){
		throw new \Exception("No implementado");
	}

	public function getInputFilter(){
		if(!$this->inputFilter){
			$inputFilter =new inputFilter();
			$factory = new InputFactory();

			$inputFilter->add($factory->createInput(array(
				'name' => 'id',
				'required' => true,
				'filters' => array(
						array('name'=>'Int')
					),
				))); 

			$inputFilter->add($factory->createInput(array(
				'name' => 'artist',
				'required' => true,
				'filters' => array(
						array('name'=>'StripTags'),
						array('name'=>'StringTrim'),
					),
				 'validators' => array(
				 		array(
				 		   'name' => 'StringLength',
				 		   'options'=>array(
				 		   		'encoding' =>'URF-8',
				 		   		'min'=>1,
				 		   		'max'=>100
				 		   	), 
				 		),
				 	),				 
				))); 

			$inputFilter->add($factory->createInput(array(
				'name' => 'title',
				'required' => true,
				'filters' => array(
						array('name'=>'StripTags'),
						array('name'=>'StringTrim'),
					),
				 'validators' => array(
				 		array(
				 		   'name' => 'StringLength',
				 		   'options'=>array(
				 		   		'encoding' =>'URF-8',
				 		   		'min'=>1,
				 		   		'max'=>100
				 		   	), 
				 		),
				 	),				 
				))); 

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}

}
?>