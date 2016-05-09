<?php
session_start();
//unset($_SESSION['img']);unset($_SESSION['cur_f_idx']);die();
if( $_GET['task'] !== 'more' || !$_GET['idx'])
{
	return;
}

$idx = (int)$_GET['idx'];
$img_ss = $_SESSION['img'];
$img_ss_len = count($img_ss);
$offset = 3;

if($idx < $img_ss_len-1)
{
	$last_idx = ($img_ss_len - 1) > ($idx + $offset) ? ($idx + $offset) : ($img_ss_len - 1);
	$return = '';
	for($i = $idx+1; $i <= $last_idx; $i++)
	{
		$item = $img_ss[$i];
		$return .=  "<img src='images/comprofiler/gallery/$item' img-idx='$i' max-length='$img_ss_len'>";
	}
	echo $return;
}
else
{
	return;
}




