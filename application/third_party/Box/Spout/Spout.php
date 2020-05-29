<?php
namespace Box\Spout;

use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

class Spout{
	
	public $writer;

	function __construct(){

	}

	public function create_excel($file, $type){
		switch ($type) {
			case 'excel':
				$this->writer = WriterFactory::create(Type::XLSX);
				break;
			case 'csv':
				$this->writer = WriterFactory::create(Type::CSV);
				break;
			case 'ods':
				$this->writer = WriterFactory::create(Type::ODS);
				break;
			default:
				$this->writer = WriterFactory::create('');
				break;
		}
		return $this->writer;
	}

	public function createStyle(){
		return new StyleBuilder();
	}

	public function createBorder(){
		return new BorderBuilder();
	}

}