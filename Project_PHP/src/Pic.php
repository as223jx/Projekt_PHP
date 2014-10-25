<?php

	class Pic{
		
		private $title;
		private $url;
		private $description;
		private $category;
		private $id;
			
		public function __construct($id, $title, $url, $description, $category){
			$this->id = $id;
			$this->title = $title;
			$this->url = $url;
			$this->description = $description;
			$this->category = $category;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function getTitle(){
			return $this->title;
		}
		
		public function getUrl(){
			return $this->url;
		}
		
		public function getDescription(){
			return $this->description;
		}
		
		public function getCategory(){
			return $this->category;
		}
	}