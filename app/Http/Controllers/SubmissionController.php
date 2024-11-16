<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        // $divisions = $this->divisionRepository->getAll();
        return view('backoffice.absent-data.submission.index');
    }
}
