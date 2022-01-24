<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage;

use Lemuria\Model\Fantasya\Exception\JsonException;

/**
 * The Json class is a convenient helper for encoding clean JSON:
 *
 * - It uses JSON_THROW_ON_ERROR to generate exceptions.
 * - It always decodes complex data into arrays.
 * - It pretty-prints encoded JSON for easy readability.
 * - It uses tab characters instead of spaces to pretty-print JSON, resulting in smaller files.
 */
final class Json
{
	public final const DEPTH = 8;

	public final const TAB_WIDTH = 4;

	public final const DECODE_OPTIONS = JSON_THROW_ON_ERROR | JSON_OBJECT_AS_ARRAY;

	public final const ENCODE_OPTIONS = JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION;

	/**
	 * @param string $json
	 * @return array
	 * @throws JsonException
	 */
	public static function decode(string $json): array {
		try {
			return json_decode($json, true, self::DEPTH, self::DECODE_OPTIONS);
		} catch (\Exception $e) {
			throw new JsonException('Invalid JSON.', 0, $e);
		}
	}

	/**
	 * @param array $data
	 * @return string
	 * @throws JsonException
	 */
	public static function encode(array $data): string {
		try {
			$json = json_encode($data, self::ENCODE_OPTIONS, self::DEPTH);
			return preg_replace_callback('/^ +/m', fn($s) => str_repeat("\t", (int)(strlen($s[0]) / self::TAB_WIDTH)), $json);
		} catch (\Exception $e) {
			throw new JsonException('Could not encode JSON.', 0, $e);
		}
	}
}
