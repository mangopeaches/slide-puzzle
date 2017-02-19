<?php
/**
 * Class to represent each block in the puzzle
 * @author Tom Breese <thomasjbreese@gmail.com>
 */
namespace Puzzle;

class Block {
	/**
	 * x,y coordinates representing the current block position
	 * @var array
	 */
	private $_current = [];

	/**
	 * x,y coordinates representing the completed block position
	 * @var array
	 */
	private $_complete = [];

	/**
	 * Flag of whether or not this is the empty block (the missing block)
	 * @var boolean
	 */
	private $_empty = false;

	/**
	 * Image/character/whatever to display as the blocks tile
	 * @var mixed
	 */
	private $_display;

	/**
	 * Constant for upward movements
	 */
	const MOVE_UP = 1;

	/**
	 * Constant for rightward movements
	 */
	const MOVE_RIGHT = 2;

	/**
	 * Constant for downward movements
	 */
	const MOVE_DOWN = 3;

	/**
	 * Constant for leftward movements
	 */
	const MOVE_LEFT = 4;

	/**
	 * Instantiate a new block object
	 * @param array $current current x,y coordinates
	 * @param array $complete completed x,y coordinates
	 * @param mixed $display whatever is to be displayed on the block
	 * @param boolean $is_empty (optional) whether or not this is an empty block
	 * @throws Exception when current or complete params are not arrays
	 */
	public function __construct($current, $complete, $display, $is_empty = false) {
		if (!is_array($current) || !is_array($complete)) {
			throw new \Exception("Current and Complete both need to by x,y coordinate arrays.");
		}
		if (count($current) != 2 || count($complete) != 2) {
			throw new \Exception("Current and Complete both need to have an x and y coordinate.");
		}
		$this->_current = $current;
		$this->_complete = $complete;
		$this->_display = $display;
		$this->_empty = $is_empty;
	}

	/**
	 * Returns whether or not the block is an empty block
	 * @return boolean
	 */
	public function is_empty() {
		return $this->_empty;
	}

	/**
	 * Returns whether or not the block is in the correct position
	 * @return boolean
	 */
	public function is_complete() {
		return $this->_current[0] == $this->_complete[0] && $this->_current[1] == $this->_complete[1];
	}

	/**
	 * Accessor for current x position
	 * @return integer $current_x current x position
	 */
	public function current_x() {
		return $this->_current[0];
	}

	/**
	 * Accessor for current y position
	 * @return integer $current_y current y position
	 */
	public function current_y() {
		return $this->_current[1];
	}

	/**
	 * Returns the current position array
	 * @return array $this->_current array of current x,y coordinates
	 */
	public function get_current() {
		return $this->_current;
	}

	/**
	 * Returns the private display value
	 * @return mixed $this->_display
	 */
	public function get_display() {
		return $this->_display;
	}

	/**
	 * Sets the blocks current position
	 * @param array $new_position x,y coordinates for where to place the block 
	 * @return void
	 * @throws Exception when the array is not valid x,y coords
	 */
	public function move($new_position) {
		if (!(is_array($new_position) && count($new_position) == 2)) {
			throw new \Exception("The new position array must be valid x,y coordinates.");
		}
		$this->_current = $new_position;
	}
}