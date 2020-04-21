<?php

/**
 * @return array[]
 * @throws RuntimeException
 */
function extract_ini(string $markdown): array
{
    if (preg_match_all(
            '/\n###\s+(?<env>開発|本番)用.*```\w+:php\.ini\n(?<ini>.+)\n```/suU',
            $markdown,
            $matches
        ) !== 2) {
        throw new RuntimeException('Failed to extract ini config');
    }
    ['開発' => $dev, '本番' => $prod] = array_combine(
        $matches['env'],
        $matches['ini']
    );
    return [
        'dev' => parse_ini_string($dev),
        'prod' => parse_ini_string($prod),
    ];
}

/**
 * @return string[]
 * @throws RuntimeException
 */
function extract_ini_descriptions(string $markdown): array
{
    // オプションの補足セクションを取り出す
    if (!preg_match(
        '/\n##\s+オプションの補足\n(?<section>.+)\n#{1,2}\s/suU',
        $markdown,
        $matches
    )) {
        throw new RuntimeException('Failed to extract オプションの補足 section');
    }

    $section = $matches['section'];
    if (!preg_match_all(
        '/(?<=\n)###\s+(?<optionName>.+)\n(?<description>.+)\n(?=###\s|$)/suU',
        $section,
        $matches
    )) {
        throw new RuntimeException(
            'Failed to extract respective descriptions to the options'
        );
    }

    return array_combine(
        $matches['optionName'],
        array_map('trim', $matches['description'])
    );
}

/**
 * @param array $ini
 * @param array $descriptions
 * @return array
 */
function check_ini(array $ini, array $descriptions): array
{
    $errors = [];
    foreach ($ini as $name => $expected) {
        $actual = ini_get($name);
        $actualTyped = normalize_ini_value($actual);
        $expectedTyped = normalize_ini_value($expected);
        /** @noinspection TypeUnsafeComparisonInspection */
        if ($actualTyped != $expectedTyped) {
            $errors[] = [
                'name' => $name,
                'expected' => $expected,
                'actual' => $actual,
                'description' => $descriptions[$name],
            ];
        }
    }
    return $errors;
}

/**
 * @param mixed $value
 * @return mixed
 */
function normalize_ini_value($value)
{
    if (is_string($value)) {
        return parse_ini_string(
            "x = $value",
            false,
            INI_SCANNER_TYPED
        )['x'];
    }
    return $value;
}

function print_errors(array $errors): void
{
    $outputs = [];

    foreach ($errors as $error) {
        $header = '## ' . $error['name'] . "\n\n";
        $body = indent(
            "現在の設定: {$error['actual']}\n" .
            "おすすめの設定: {$error['expected']}\n" .
            "\n" .
            $error['description'] .
            "\n",
            0
        );
        $outputs[] = $header . $body;
    }

    echo implode("\n", $outputs);
    echo sprintf("\n---\n\n以上、%u個の設定を提案をしました。\n", count($errors));
}

function indent(string $string, int $size): string
{
    $indent = str_repeat(' ', $size);
    return rtrim($indent . str_replace("\n", "\n" . $indent, $string), ' ');
}

function main(array $argv): void
{
    $env = $argv[1] ?? 'prod';
    if (!in_array($env, ['dev', 'prod'])) {
        throw new RuntimeException(
            'The first argument must be `dev` or `prod`'
        );
    }
    $ucanlabsAwesomePost = file_get_contents(
        'https://qiita.com/ucan-lab/items/0d74378e1b9ba81699a9.md'
    );
    $ini = extract_ini($ucanlabsAwesomePost);
    $descriptions = extract_ini_descriptions($ucanlabsAwesomePost);
    $errors = check_ini($ini[$env], $descriptions);
    print_errors($errors);
}

main($argv);
