<?php

namespace App\Http\Repository;

use App\Models\Criteria;

class CriteriaRepository
{
    public function getAll()
    {
        try {
            return Criteria::orderBy('id', 'asc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Criteria::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $criteria = new Criteria();
            $criteria->name = $data->name;
            $criteria->type = $data->type;
            $criteria->weight = $data->weight;
            $criteria->save();

            return $criteria;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        try {
            $criteria = Criteria::find($id);
            $criteria->name = $data->name;
            $criteria->type = $data->type;
            $criteria->weight = $data->weight;
            $criteria->save();

            return $criteria;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return Criteria::find($id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}