<?php
	namespace Album\Entity;

	use Doctrine\ORM\Mapping as ORM;

	/**
	*	Representa un Album Musical
	*	@ORM\Entity 
	*	@ORM\Table(name="album")	
	*	@property string $artist;
	*	@property string $title;
	*	@property int $id;
	*/

	class Album{
		/**
		*	@ORM\Id
		*	@ORM\Column(type="integer")
		*	@ORM\GeneratedValue(strategy="AUTO")
		*/
		protected $id;

		/**
		*	@ORM\Column(type="string")
		*/
		protected $artist;
		
		/**
		*	@ORM\Column(type="string")
		*/
		protected $title;


		public function __get($property){
			return $this->$property;
		}

		public function __set($property,$value){
			$this->property = $value;
		}

		/**
		* Convierte el objeto a un array
		* @return array
		*/
		public function getArrayCopy(){
			return get_object_vars($this);
		}

		/**
		* Inicializa el objeto desde un array
		* @param array $data
		*/
		public function populate($data = array()){
			$this->id = $data['id'];
			$this->artist = $data['artist'];
			$this->title = $data['title'];
		}

	}
?>