<?php
/**
 * Driver class to run the game
 * @author Tom Breese <thomasjbreese@gmail.com>
 */
include(dirname(__FILE__).'/src/Puzzle.php');
include(dirname(__FILE__).'/src/Block.php');

/**
 * oo
 * xx
 * solved:
 * xo
 * ox
 */
$board = [
		[
			[1,1],
			[0,0],
			'x',
		],
		[
			[0,1],
			[0,1],
			'o',
		],
		[
			[0,0],
			[1,0],
			'o',
		],
		[
			[1,0],
			[1,1],
			'x',
		],
	];

try {
	$puzzle = Puzzle\Puzzle::instance($board);
	$puzzle->draw();
} catch(Exception $e) {
	die($e->getMessage());
}
