<?php

	class Pic{
		
		private $title;
		private $url;
		private $description;
		private $category;
			
		public function __construct($title, $url, $description, $category){
			$this->title = $title;
			$this->url = $url;
			$this->description = $description;
			$this->category = $category;
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