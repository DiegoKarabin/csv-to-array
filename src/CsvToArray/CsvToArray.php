<?php

namespace CsvToArray;

class CsvToArray
{
	public static function parse_file($file_name, $clean_headers = true, $delimiter = ',', $enclosure = '"', $escape = "\\")
	{
		return self::parse_str(file_get_contents($file_name), $clean_headers, $delimiter, $enclosure, $escape);
	}

	public static function parse_str($str_data, $clean_headers = true, $delimiter = ',', $enclosure = '"', $escape = "\\")
	{
		$array_lines = array_map(
			function ($element) use ($delimiter, $enclosure, $escape) {
				return str_getcsv($element, $delimiter, $enclosure, $escape);
			},
			explode("\n", $str_data)
		);

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
