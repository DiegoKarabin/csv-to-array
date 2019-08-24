<?php

namespace CsvToArray;

class CsvToArray
{
	public static function remove_double_quotes($str)
	{
		return str_replace('"', '', $str);
	}

	public static function split_csv_line_to_array($str_line)
	{
		$str_line = str_replace("\r", '', $str_line);

		return array_map(
			function ($element) {
				return remove_double_quotes($element);
			},
			explode('","', $str_line)
		);
	}

	public static function parse_strcsv_to_array($str_data)
	{
		$array_lines = explode("\n", $str_data);
		$array_keys = split_csv_line_to_array(array_shift($array_lines));
		$array_data = array();

		foreach ($array_lines as $line) {
			$array_record_data = split_csv_line_to_array($line);
			$array_record = array();

			foreach ($array_keys as $index => $key) {
				$array_record[$key] = $array_record_data[$index];
			}

			$array_data[] = $array_record;
		}

		return $array_data;
	}
}
