<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Storage;

use Lemuria\Model\Exception\JsonException;

final class Json
{
	public const DEPTH = 8;

	public const DECODE_OPTIONS = JSON_THROW_ON_ERROR | JSON_OBJECT_AS_ARRAY;

	public const ENCODE_OPTIONS = JSON_THROW_ON_ERROR | JSON_HEX_QUOT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION;

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
			return json_encode($data, self::ENCODE_OPTIONS, self::DEPTH);
		} catch (\Exception $e) {
			throw new JsonException('Could not encode JSON.', 0, $e);
		}
	}
}
