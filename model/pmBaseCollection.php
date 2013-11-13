<?php

//require_once("pmBase.php");

class pmBaseCollection implements IteratorAggregate {
	private $items = array();
	function populate($items, $class) {
		foreach($items as $obj) {
			$item = new $class();
			$item->set($obj->guid, $obj->name);
			$this->items[$item->getID()] = $item;
		}
	}
	public function getIterator() {
		return new ArrayIterator( $this->items );
	}
}

?>
