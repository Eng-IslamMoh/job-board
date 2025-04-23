<?php

namespace App\Services\Filter;

use Illuminate\Database\Eloquent\Builder;
use App\Services\Filter\FilterParser;

class FilterService
{
    public function apply(Builder $query, string $filter): Builder
    {
        $conditions = (new FilterParser())->parse($filter);
        return $this->applyNode($query, $conditions);
    }

    protected function applyNode(Builder $query, array $node): Builder
    {
        if ($node['type'] === 'group') {
            $method = strtolower($node['operator']) === 'or' ? 'orWhere' : 'where';

            $query->$method(function ($q) use ($node) {
                foreach ($node['conditions'] as $child) {
                    $this->applyNode($q, $child);
                }
            });
        } elseif ($node['type'] === 'condition') {
            $query = $this->applyCondition($query, $node);
        }

        return $query;
    }

    protected function applyCondition(Builder $query, array $condition): Builder
    {
        $field = $condition['field'];
        $operator = $condition['operator'];
        $value = $condition['value'];

        if (str_starts_with($field, 'attribute:')) {
            $attributeKey = str_replace('attribute:', '', $field);

            $query->whereHas('attributes', function ($q) use ($attributeKey, $operator, $value) {
                $q->whereHas('attribute', function ($q2) use ($attributeKey) {
                    $q2->where('name', $attributeKey);
                })->where('value', $operator, $value);
            });
        } elseif (in_array($operator, ['HAS_ANY', 'IS_ANY'])) {
            if (str_contains($field, '.')) {
                [$relation, $column] = explode('.', $field);
            } else {
                $relation = $field;
                $column = match ($relation) {
                    'languages' => 'name',
                    'locations' => 'state',
                    default => 'name',
                };
            }

            $query->whereHas($relation, function ($q) use ($value, $column) {
                $q->whereIn($column, $value);
            });
        } else {
            $query->where($field, $operator, $this->normalizeValue($value));
        }

        return $query;
    }

    protected function normalizeValue(string $value)
    {
        if ($value === 'true') return true;
        if ($value === 'false') return false;
        if (is_numeric($value)) return $value + 0;
        return trim($value, "\"'");
    }
}
