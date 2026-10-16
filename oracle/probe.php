<?php

declare(strict_types=1);

function brackets_match(string $input): bool
{
    $characters = str_split($input);

    $bracketsStack = array_reduce(
        $characters,
        function (array $stack, string $char): array {
            $isOpeningBracket = function ($char) {
                return in_array($char, ['[', '{', '(']);
            };

            $isClosingBracket = function ($char) {
                return in_array($char, [']', '}', ')']);
            };

            $matchesLastOpenBracket = function ($char, $stack) {
                $prev = array_pop($stack);

                $lookupOpeningBracket = [
                    ']' => '[',
                    '}' => '{',
                    ')' => '(',
                ];

                return $lookupOpeningBracket[$char] == $prev;
            };

            if ($isOpeningBracket($char)) {
                $stack[] = $char;
            }

            if ($isClosingBracket($char)) {
                if ($matchesLastOpenBracket($char, $stack)) {
                    array_pop($stack);
                } else {
                    $stack[] = $char; // unopened bracket
                }
            }
            return $stack;
        },
        []
    );

    return empty($bracketsStack);
}

$__in = json_decode('["[]", "", "[[", "}{", "{]", "{ }", "{[]}", "{}[]", "([{}({}[])])", "{[)][]}", "([{])", "[({}])", "{}[", "[]]", ")()", "{)()"]', true);
$__out = [];
foreach ($__in as $x) {
  try { $__out[] = ["ok" => true, "v" => brackets_match($x)]; }
  catch (\Throwable $e) { $__out[] = ["ok" => false, "e" => get_class($e)]; }
}
echo json_encode(["out" => $__out]);
