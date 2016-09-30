<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/8/1
 * Time: 上午11:36
 */
require_once __DIR__ . "/../Lib/BaseInfo.php";
use Applications\T2Gateway\Lib\BaseInfo;

class StructSummary
{
	private $class_list = [];
	private $field_list = [];

	public function __construct($dir)
	{
		foreach (glob($dir) as $file)
		{
			require_once($file);
			$start_pos = strrpos($file, "/") + 1;
			$class_name = 'Applications\\T2Gateway\\Info\\'. substr($file, $start_pos, -4);
			//var_dump($class_name, class_exists($class_name), is_subclass_of($class_name, BaseInfo::class));die;

			if (class_exists($class_name) && is_subclass_of($class_name, BaseInfo::class))
			{
				$this->class_list[] = $class_name;
			}
		}

//		foreach ($this->class_list as $class)
//		{
//			$attribute_list = $class::getAttributes();
//			$this->field_list = array_merge($this->field_list, $attribute_list);
//		}

		$content = file_get_contents("field_info.txt");
		$list = explode("\n", $content);
		foreach($list as $line)
		{
			list($field, ,$explain) = explode("\t", $line);
			$this->field_list[$field] = $explain;
		}

	}

	public function importAllField()
	{
		$line = [];
		foreach ($this->class_list as $class)
		{
			$attribute_list = $class::getAttributes();

			$line[] = $class;
			$line[] = "字段 含义 备注";

			foreach ($attribute_list as $key => $value)
			{
				$value = isset($this->field_list[$key]) ? $this->field_list[$key] : $value;

				$line[] = "{$key} {$value}";
			}
			$line[] = "";
		}

		$content = implode("\n", $line);
		file_put_contents('doc.txt', $content);
	}
}

$dir = __DIR__. '/../Info/*.php';
$obj = new StructSummary($dir);
$obj->importAllField();