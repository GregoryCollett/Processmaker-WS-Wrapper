<?php

//l

class pmBaseCollection implements IteratorAggregate {
	private $items = array();
	private $index = array();
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
	public function getByName($name) {
		if (isset($this->index[$name])) {
			return $this->index[$name];
		} else {
			return array();
		}
	}
	public function add($item) {
		$this->items[$item->getID()] = &$item;
		if (!isset($this->index[$item->getName()])) {$this->index[$item->getName()] = array();}
		$this->index[$item->getName()][] = &$item;
	}
	public function printTree($depth = 0, $showId = false) {
		foreach($this as $item) {
			$item->printLeaf($depth, $showId);
		}
	}
}

class NoSuchItemException extends Exception {}

?>
