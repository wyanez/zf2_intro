<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Form\AlbumForm;
use Album\Form\AlbumFilter;
use Zend\Json\Json;

use Album\Entity\Album;
use Doctrine\ORM\EntityManager;

class AlbumController extends AbstractActionController{
	protected $form;
	/**
	*	@var Doctrine\ORM\EntityManager
	*/
	protected $em;

	public function indexAction(){
		$albums = $this->getEntityManager()->getRepository('Album\Entity\Album')->findAll();
		return new ViewModel( array(
				'albums' =>$albums,
			)
		);
	}

	public function addAction(){
		$form=$this->getForm('Agregar');

		$request= $this->getRequest();
		if ($request->isPost()){
			//Se procesa el form
			$is_valid = $this->filterForm($form,$request->getPost());
			if($is_valid){
				$album = new Album(); 
				$album->populate($form->getData());
				$this->getEntityManager()->persist($album);
				$this->getEntityManager()->flush();

				$this->flashMessenger()->addMessage('Album incluido exitosamente!');
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
			$album = $this->getEntityManager()->find('Album\Entity\Album',$id);
		}
		catch(\Exception $ex){
			return $this->redirect()->toRoute('album');	
		}

		$form = $this->getForm('Editar');
		$form->setBindOnValidate(false);  //OJO
		$form->bind($album);

		$request= $this->getRequest();
		if ($request->isPost()){
			//Se procesa el form
			$is_valid = $this->filterForm($form,$request->getPost());
			if($is_valid){
				$form->bindValues();
				$this->getEntityManager()->flush();

				$this->flashMessenger()->addMessage('Album editado exitosamente!');
				return $this->redirect()->toRoute('album');	
			}	
		}

		return array('id'=> $id , 
			         'form' =>$form);
	}
	
	public function deleteAction(){
		$request= $this->getRequest();
		$response= $this->getResponse(); 
		if($request->isPost()){
	    	$id= (int) $request->getPost('id');
	        $album = $this->getEntityManager()->find('Album\Entity\Album',$id);
	        if($album){
	        	$this->getEntityManager()->remove($album);
	        	$this->getEntityManager()->flush();
	        	$ok=true;
	        }
	        else $ok=false;
	       	$response->setContent(Json::encode(array('response' => $ok)));
	  	}
		return $response;
	}


	private function getForm($modo){
		$this->form = new AlbumForm();
		$this->form->get('submit')->setValue($modo);
		return $this->form;
	}

	private function filterForm($form,$data){
		$albumFilter = new AlbumFilter();
		$form->setInputFilter($albumFilter->getInputFilter());
		$form->setData($data);
		return $form->isValid();
	}

	public function getEntityManager(){
		if($this->em == null){	
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}	
		return $this->em;
	}

	public function setEntityManager(EntityManager $em){
		$this->em = $em;
	}
}
?>