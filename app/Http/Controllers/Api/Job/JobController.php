<?php

namespace App\Http\Controllers\Api\Job;

use App\Helpers\GeneralApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Job\JobResource;
use App\Interfaces\Api\Job\JobRepositoryInterface;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(private JobRepositoryInterface $repo, private GeneralApiResponse $gApiRes) {}

    public function index(Request $request)
    {
        try {
            $jobs = $this->repo->index($request->all());
            return $this->gApiRes->returnData('jobs', $this->gApiRes->handlePaginate($jobs, JobResource::class), 'Jobs retrieved successfully');
        } catch (\Exception $e) {
            return $this->gApiRes->returnError($e->getCode() ?: 500, $e->getMessage());
        }
    }
}
