<?php

class ProgramItem
{
	public $id = '';
	public $title = '';
	public $description = '';
	public $type = '';
	public $info = '';
	public $dates = array();
	public $date = '';
	public $timestamp = '';
	
	public function __construct( $data )
	{
		$this->title = $data['title'];
		$this->description = $data['description'];
		$this->type = $data['type'];
		$this->info = $data['info'];
		$this->hash = md5($data['title']);
		$this->dates = $data['dates'];
	}
	
	public function setTimestamp( $date_raw )
	{
		$this->date = $date_raw;
		$d = intval($date_raw{0}.$date_raw{1});
		$m = intval($date_raw{3}.$date_raw{4});
		$y = intval($date_raw{6}.$date_raw{7}.$date_raw{8}.$date_raw{9});
		$h = intval($date_raw{13}.$date_raw{14});// + 7; //nutny fix, ale neviem preco
		$i = intval($date_raw{16}.$date_raw{17});
		$this->timestamp = mktime($h,$i,0,$m,$d,$y);
	}
}