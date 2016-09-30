<?php
foreach(glob(__DIR__. '/Config/*.php') as $file)
{
	require_once($file);
}