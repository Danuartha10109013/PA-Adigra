<?php

namespace App\Http\Controllers;

use App\Http\Repository\OfficeRepository;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    private $officeRepository;

    public function __construct(OfficeRepository $officeRepository)
    {
        $this->officeRepository = $officeRepository;
    }

    public function index()
    {
        // $offices = $this->officeRepository->getAll();
        return view('backoffice.office.index');
    }
}
