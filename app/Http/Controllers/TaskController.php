<?php

namespace App\Http\Controllers;

use App\Http\Repository\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(Request $request) 
    {
        $tasks = $this->taskRepository->getAll($request);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return view('backoffice.task.index', compact('tasks', 'bulan', 'tahun'));
    }

    public function create(Request $request)
    {
        $this->taskRepository->store($request);

        return redirect('/backoffice/task')->with('success', 'Berhasil menambahkan task baru');
    }

    public function update(Request $request, $id)
    {
        $this->taskRepository->update($id, $request);

        return redirect('/backoffice/task')->with('success', 'Berhasil mengubah task');
    }

    public function delete($id)
    {
        $this->taskRepository->delete($id);

        return redirect('/backoffice/task')->with('success', 'Berhasil menghapus task');
    }
}
