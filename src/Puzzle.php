<?php
/**
 * Puzzle class contains all functionality related to the puzzle itself
 * @author Tom Breese <thomasjbreese@gmail.com>
 */
namespace Puzzle;

class Puzzle {
	/**
	 * Array containing the actual board itself
	 * @var array of Blocks
	 */
	private $_puzzle = [];

	/**
	 * The dimensions of our puzzle, 4 for 4x4, 5 for 5x5, etc.
	 * @var integer
	 */
	private $_size;

	/**
	 * Reference to the current class, for singleton
	 * @var Object
	 */
	private static $_instance = null;

	/**
	 * Singleton method to initialize a new puzzle
	 * @param array $puzzle_array array containing an array map of the puzzle
	 * @return Puzzle newly created obejct, or existing reference, when called afterward
	 */
	public static function instance($puzzle_array) {
		// if we haven't instantiated the class yet, do so and store the reference locally
		if (self::$_instance === null) {
			self::$_instance = new Puzzle($puzzle_array);
		}
		return self::$_instance;
	}

	/**
	 * Instantiate the Puzzle object and initialize the private puzzle array
	 * @return void
	 * @throws Exception when $puzzle_array is not an array
	 */
	private function __construct($puzzle_array) {
		if (!is_array($puzzle_array)) {
			throw new \Exception("The supplied puzzle must be an array.");
		}
		// TODO: add puzzle validation check
		// set the empty piece somewhere randomly in the puzzle
		$empty_block = rand(0, count($puzzle_array) - 1);
		foreach ($puzzle_array as $index => $block) {
			$this->_puzzle[] = new Block($block[0], $block[1], $block[2], ($index == $empty_block));
		}
		$this->_size = sqrt(count($puzzle_array));
	}

	/**
	 * Attempt to slide a block in a given direction
	 * @param mixed $block_id unique id for the block
	 * @param string $position movement direction
	 * @return boolean indicates whether or not the block moved
	 */
	public function slide($block_index, $position) {
		// first just make sure the block exists
		if (!isset($this->_puzzle[$block_index])) {
			return false;
		}
		// first locate the block
		switch ($position) {
			case Block::MOVE_UP:
				// first check if a move upwards is even possible
				if ($this->_puzzle[$block_index]->current_x() == 0) {
					return false;
				}
				// now check that the above block is the empty block
				// locate the block above this block and check if it's the empty block
				foreach ($this->_puzzle as $current_block_index => $block) {
					if ($block->current_y() == $this->_puzzle[$block_index]->current_y()) {
						if ($block->current_x() == ($this->_puzzle[$block_index]->current_x() - 1)) {
							// check if this is the empty block
							if ($block->is_empty()) {
								// we can swap the blocks!
								$this->_swap($block_index, $current_block_index);
								return true;
							}
						}
					}
				}
				break;
			case Block::MOVE_RIGHT:
				// first check if a move right is even possible
				if ($this->_puzzle[$block_index]->current_y() == ($this->_size - 1)) {
					return false;
				}
				// now check that the right block is the empty block
				// locate the block to the right of this block and check if it's the empty block
				foreach ($this->_puzzle as $current_block_index => $block) {
					if ($block->current_x() == $this->_puzzle[$block_index]->current_x()) {
						if ($block->current_y() == ($this->_puzzle[$block_index]->current_y() + 1)) {
							// check if this is the empty block
							if ($block->is_empty()) {
								// we can swap the blocks!
								$this->_swap($block_index, $current_block_index);
								return true;
							}
						}
					}
				}
				break;
			case Block::MOVE_DOWN:
				// first check if a move down is even possible
				if ($this->_puzzle[$block_index]->current_x() == ($this->_size - 1)) {
					return false;
				}
				// now check that the down block is the empty block
				// locate the block below this block and check if it's the empty block
				foreach ($this->_puzzle as $current_block_index => $block) {
					if ($block->current_y() == $this->_puzzle[$block_index]->current_y()) {
						if ($block->current_x() == ($this->_puzzle[$block_index]->current_x() + 1)) {
							// check if this is the empty block
							if ($block->is_empty()) {
								// we can swap the blocks!
								$this->_swap($block_index, $current_block_index);
								return true;
							}
						}
					}
				}
				break;
			case Block::MOVE_LEFT:
				// first check if a move left is even possible
				if ($this->_puzzle[$block_index]->current_x() == ($this->_size - 1)) {
					return false;
				}
				// now check that the left block is the empty block
				// locate the block to the left of this block and check if it's the empty block
				foreach ($this->_puzzle as $current_block_index => $block) {
					if ($block->current_x() == $this->_puzzle[$block_index]->current_x()) {
						if ($block->current_y() == ($this->_puzzle[$block_index]->current_y() - 1)) {
							// check if this is the empty block
							if ($block->is_empty()) {
								// we can swap the blocks!
								$this->_swap($block_index, $current_block_index);
								return true;
							}
						}
					}
				}
				break;
			default:
				break;
		}
		// default if we didn't find a valid move above
		return false;
	}

	/**
	 * Swaps the position of any two blocks
	 * @param integer $block_index index for one of the blocks to switch
	 * @param integer $other_block_index index for the other block to switch
	 * @return void
	 */
	private function _swap($block_index, $other_block_index) {
		$tmp = $this->_puzzle[$block_index]->get_current();
		$this->_puzzle[$block_index]->move($this->_puzzle[$other_block_index]->get_current());
		$this->_puzzle[$other_block_index]->move($tmp);
	}

	/**
	 * Checks that the supplied puzzle is a valid game puzzle
	 * @return bool
	 */
	private function is_valid_puzzle() {
		// first make sure it's a non-empty array
		if (is_array($this->_puzzle) && $this->_size > 0) {
			// validate it's got the correct length for a puzzle
			if (floor($this->_size) != $this->_size) {
				return false;
			}
			// check that we have both a valid current status for our puzzle and a valid stopping case
			$status_puzzle = [];
			$solved_puzzle = [];
			foreach ($this->_puzzle as $block) {
				// each block must have 4 items (current x,y and correct x,y coords)
				if (!is_array($block) || count($block) != 4) {
					return false;
				}
				// TODO: continue with this later, just assume correct for now
			}
		}
		// default case when nothing matched
		return false;
	}

	/**
	 * Displays the current puzzle
	 * @return the puzzle output to the console
	 */
	public function draw() {
		for ($current_x = 0; $current_x < $this->_size; $current_x++) {
			for ($current_y = 0; $current_y < $this->_size; $current_y++) {
				foreach ($this->_puzzle as $index => $block) {
					if ($block->current_x() == $current_x && $block->current_y() == $current_y) {
						echo (!$block->is_empty() ? $block->get_display() : ' ');
						if ($current_y == $this->_size - 1) {
							echo "\n";
						}
					}
				}
			}
		}
	}

	/**
	 * Determines if the puzzle is solved
	 * @return bool
	 */
	public function solved() {
		// iterate over the puzzle and check that all the blocks are in the correct place
		foreach ($this->_puzzle as $index => $block) {
			//if the current position matches the complete condition for all blocks then we're done
			if ($block[0] != $block[2] || $block[1] != $block[3]) {
				return false;
			}
		}
		return true;
	}
}