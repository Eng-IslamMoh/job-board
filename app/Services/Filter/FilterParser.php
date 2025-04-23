<?php

namespace App\Services\Filter;

class FilterParser
{
    public function parse(string $filter): array
    {
        $tokens = $this->tokenize($filter);
        return $this->parseGroup($tokens);
    }

    protected function tokenize(string $filter): array
    {
        $pattern = '/\(|\)|AND|OR|[^\s()]+(?:\s*\([^)]*\))?|[^\s()]+/i';
        preg_match_all($pattern, $filter, $matches);

        return array_map(fn($t) => trim($t), $matches[0]);
    }

    protected function parseGroup(array &$tokens): array
    {
        $group = ['type' => 'group', 'operator' => 'AND', 'conditions' => []];

        while ($token = array_shift($tokens)) {
            $token = trim($token);

            if (strtoupper($token) === 'AND' || strtoupper($token) === 'OR') {
                $group['operator'] = strtoupper($token);
                continue;
            }

            if ($token === '(') {
                $group['conditions'][] = $this->parseGroup($tokens);
            } elseif ($token === ')') {
                break;
            } else {
                $raw = $token;
                while (!empty($tokens) && !in_array(strtoupper($tokens[0]), ['AND', 'OR', ')'])) {
                    $raw .= ' ' . array_shift($tokens);
                }

                $group['conditions'][] = $this->parseCondition($raw);
            }
        }

        return $group;
    }

    protected function parseCondition(string $raw): array
    {
        if (preg_match('/(.+?)\s+(HAS_ANY|IS_ANY)\s*\((.+)\)/i', $raw, $matches)) {
            return [
                'type' => 'condition',
                'field' => trim($matches[1]),
                'operator' => strtoupper(trim($matches[2])),
                'value' => array_map('trim', explode(',', $matches[3]))
            ];
        }

        if (preg_match('/(.+?)(=|!=|>=|<=|>|<)(.+)/', $raw, $matches)) {
            return [
                'type' => 'condition',
                'field' => trim($matches[1]),
                'operator' => trim($matches[2]),
                'value' => trim($matches[3])
            ];
        }

        throw new \InvalidArgumentException("Invalid filter condition: $raw");
    }
}
