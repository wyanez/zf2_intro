<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Form\AlbumForm;
use Album\Form\AlbumFilter;
use Album\Model\Album;

class AlbumController extends AbstractActionController{
	protected $albumTable;
	protected $form;

	public function indexAction(){
		return new ViewModel( array(
				'albums' =>$this->getAlbumTable()->fetchAll(),
			));
	}

	public function addAction(){
		$form=$this->getForm('Agregar');

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
		$id = (int) $this->params()->fromRoute('id',0);
		if(!$id){
			return $this->redirect()->toRoute('album');
		} 

		try{
			$album = $this->getAlbumTable()->getAlbum($id);
		}
		catch(\Exception $ex){
			return $this->redirect()->toRoute('album');	
		}

		$form = $this->getForm('Editar');
		$form->bind($album);
		 
		$request= $this->getRequest();
		if ($request->isPost()){
			//Se procesa el form
		}

		return array('id'=> $id , 
			         'form' =>$form);
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

	private function getForm($modo){
		$this->form = new AlbumForm();
		$this->form->get('submit')->setValue($modo);
		return $this->form;
	}
}
?>