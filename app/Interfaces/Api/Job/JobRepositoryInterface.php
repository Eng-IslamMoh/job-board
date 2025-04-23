<?php

namespace App\Interfaces\Api\Job;

interface JobRepositoryInterface
{
    public function index(array $request = []);
}
