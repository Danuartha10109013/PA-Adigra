<?php

namespace App\Http\Repository;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    public function getAll($data)
    {
        try {
            
            $tasks = Task::orderBy('id', 'desc');

            if ($data->bulan && $data->tahun) {
                $tasks->whereMonth('created_at', $data->bulan)->whereYear('created_at', $data->tahun);
            }

            if (Auth::user()->role_id == 1) {
                return $tasks->get();
            } else {
                return $tasks->where('user_id', Auth::user()->id)->get();
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Task::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $task = new Task();
            $task->user_id = Auth::user()->id;
            $task->task = $data->task;
            $task->save();

            return $task;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        try {
            $task = Task::find($id);
            $task->task = $data->task;
            $task->save();

            return $task;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $task = Task::find($id);
            $task->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}