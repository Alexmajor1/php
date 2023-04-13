<?php

$comments = Array(
	Array(1, 1, "Comment 1"),
	Array(2, 1, "Comment 2"),
	Array(3, 2, "Comment 3"),
	Array(4, 1, "Comment 4"),
	Array(5, 2, "Comment 5"),
	Array(6, 3, "Comment 6"),
	Array(7, 7, "Comment 7")
);
$result = '<ol>';
$keys = array();

foreach($comments as $comment) {
	$keys[$comment[1]][] = $comment[0];
}

function generate($keys, $comments, $key)
{
	$result = '<ol>';
	var_dump('g'.$key);
	$result .= '<li>'.$comments[$key-1][2].'</li>';
	if(isset($keys[$key])) {
		foreach($keys[$key] as $id => $value) {
			var_dump('f'.$value);
			$result = '<ol>';
			if(isset($keys[$value]) && $value != $key) {
				$result .= generate($keys, $comments, $keys[$value-1][0], $value).'</ol>';
			} elseif($value != $key) {
				$result .= '<li>'.$comments[$value-1][2].'</li>';
			}
			$result .= '</ol>';
		}
	}
	
	$result .= '</ol>';
	unset($keys[$value]);
	
	return $result;
}

var_dump($keys);
$result = '<ol>';
foreach($keys as $id => $key) {
	$result .= generate($keys, $comments, $id);
}
$result .= '</ol>';
echo $result;
?>