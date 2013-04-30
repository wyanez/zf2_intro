<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Form\AlbumForm;
use Album\Form\AlbumFilter;
use Album\Model\Album;

class AlbumController extends AbstractActionController{
	protected $albumTable;

	public function indexAction(){
		return new ViewModel( array(
				'albums' =>$this->getAlbumTable()->fetchAll(),
			));
	}

	public function addAction(){
		$form = new AlbumForm();
		$form->get('submit')->setValue('Agregar');

		$request= $this->getRequest();
		if ($request->isPost()){
			//Se procesa el form
			$albumFilter = new AlbumFilter();
			$form->setInputFilter($albumFilter->getInputFilter());
			$form->setData($request->getPost());

			if($form->isValid()){
				$album = new Album(); 
				$album->exchangeArray($form->getData());
				$this->getAlbumTable()->saveAlbum($album);

				//TODO Imprimir un mensaje de exito
				return $this->redirect()->toRoute('album');
			}
		}
		return array('form' => $form);
	}

	public function editAction(){
	}

	public function deleteAction(){
	}

	private function getAlbumTable(){
		if(!$this->albumTable){
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('Album\Model\AlbumTable'); 
		}
		return $this->albumTable;
	}
}
?>