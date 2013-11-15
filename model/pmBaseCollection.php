<?php

//require_once("pmBase.php");

class pmBaseCollection implements IteratorAggregate {
	private $items = array();
	function populate($items, $class) {
		foreach($items as $obj) {
			$item = new $class();
			$item->set($obj->guid, $obj->name);
			//$this->items[$item->getID()] = $item;
			$this->add($item);
		}
	}
	public function getIterator() {
		return new ArrayIterator( $this->items );
	}
	public function get($id) {
		if (isset($this->items[$id])) {
			return $this->items[$id];
		} else {
			throw new NoSuchItemException("No item in collection for '{$id}'.");
		}
	}
	public function add($item) {$this->items[$item->getID()] = &$item;}
}

class NoSuchItemException extends Exception {}

?>
