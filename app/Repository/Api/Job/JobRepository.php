<?php

namespace App\Repository\Api\Job;

use App\Interfaces\Api\Job\JobRepositoryInterface;
use App\Models\Job;
use App\Services\Filter\FilterService;

class JobRepository implements JobRepositoryInterface
{
    public function __construct(private FilterService $filterService) {}

    public function index($request = [])
    {
        $limit = $request['limit'] ?? 10;
        $filter = $request['filter'] ?? null;

        $query = Job::query();

        if ($filter) {
            $query = $this->filterService->apply($query, $filter);
        }

        return $query->paginate($limit);
    }
}
