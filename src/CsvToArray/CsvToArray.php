<?php

namespace CsvToArray;

class CsvToArray
{
	public static function parse_file($file_name, $clean_headers = true)
	{
		return self::parse_str(file_get_contents($file_name), $clean_headers);
	}

	public static function parse_str($str_data, $clean_headers = true)
	{
		$array_lines = array_map('str_getcsv', explode("\n", $str_data));
		$headers = array_shift($array_lines);
		$array_keys = $clean_headers
		    ? array_map(
				function ($element) {
					return str_replace(' ', '_', trim(strtolower($element)));
				},
				$headers
			  )
			: $headers;
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
