<?php

namespace CsvToArray;

class CsvToArray
{
	public static function parse_file($file_name)
	{
		return self::parse_str(file_get_contents($file_name));
	}

	public static function parse_str($str_data)
	{
		$array_lines = array_map('str_getcsv', explode("\n", $str_data));
		$array_keys = array_map(
			function ($element) {
				return str_replace(' ', '_', trim(strtolower($element)));
			},
			array_shift($array_lines)
		);
		$array_data = array();

		foreach ($array_lines as $line) {
			$array_record = array();

			foreach ($array_keys as $index => $key) {
				$array_record[$key] = $line[$index];
			}

			$array_data[] = $array_record;
		}

		return $array_data;
	}
}
