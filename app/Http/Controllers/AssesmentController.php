<?php

namespace App\Http\Controllers;

use App\Http\Repository\AssesmentRepository;
use App\Http\Repository\CriteriaRepository;
use App\Http\Repository\UserRepository;
use App\Models\Assesment;
use Illuminate\Http\Request;

class AssesmentController extends Controller
{
    private $assesmentRepository;
    private $userRepository;
    private $criteriaRepository;

    public function __construct(AssesmentRepository $assesmentRepository, UserRepository $userRepository, CriteriaRepository $criteriaRepository)
    {
        $this->assesmentRepository = $assesmentRepository;
        $this->userRepository = $userRepository;
        $this->criteriaRepository = $criteriaRepository;
    }

    public function index()
    {
        $assesments = $this->assesmentRepository->getAll();
        $users = $this->userRepository->getAllNonAdmin();
        $criterias = $this->criteriaRepository->getAll();
        return view('backoffice.assesment-data.assesment.index', compact(['assesments', 'users', 'criterias']));
    }

    public function result()
{
    // 1. ambil data
    $karyawan = $this->userRepository->getAllNonAdmin();
    $kriteria = $this->criteriaRepository->getAll();
    $nilai = $this->assesmentRepository->getAll();

    // 2. normalisasi nilai
    $normalisasi = [];
    foreach ($kriteria as $k) {
        $max = Assesment::where('criteria_id', $k->id)->max('score');
        $min = Assesment::where('criteria_id', $k->id)->min('score');

        foreach ($nilai->where('criteria_id', $k->id) as $n) {
            $r = ($k->type == 'benefit') 
                ? ($max > 0 ? $n->score / $max : 0)
                : ($n->score > 0 ? $min / $n->score : 0);

            $normalisasi[$n->user_id][$k->id] = $r;
        }
    }

    // 3. perhitungan nilai preferensi
    $hasil = [];
    foreach ($karyawan as $k) {
        $total = 0;
        $normalisasiUser = $normalisasi[$k->id] ?? [];

        foreach ($kriteria as $kri) {
            $nilaiNormalisasi = $normalisasiUser[$kri->id] ?? 0;
            $total += $kri->weight * $nilaiNormalisasi;
        }

        $hasil[$k->id] = [
            'user' => $k,
            'normalisasi' => $normalisasiUser,
            'total' => $total,
        ];
    }

    // 4. sorting
    usort($hasil, fn ($a, $b) => $b['total'] <=> $a['total']);

    return view('backoffice.assesment-data.assesment.result', compact(['hasil', 'kriteria']));
}

    public function resultSalah()
    {
        // 1. ambil data
        $karyawan = $this->userRepository->getAllNonAdmin();
        $kriteria = $this->criteriaRepository->getAll();
        $nilai = $this->assesmentRepository->getAll();

        // 2. normalisasi nilai
        $normalisasi = [];
        foreach ($kriteria as $key => $k) {
            $max = Assesment::where('criteria_id', $k->id)->max('score');
            $min = Assesment::where('criteria_id', $k->id)->min('score');

            foreach ($nilai->where('criteria_id', $k->id) as $key => $n) {
                $r = ($k->type == 'benefit') 
                    ? $n -> score / $max
                    : $min / $n -> score;

                $normalisasi[$n->user_id][$k->id] = $r;
            }
        }

        // 3. perhitungan nilai preferensi
        $hasil = [];
        foreach ($karyawan as $key => $k) {
            $total = 0;
            foreach ($kriteria as $key => $kri) {
                $total += $kri->weight * $normalisasi[$k->id][$kri->id];
            }
            $hasil[$k->id] = [
                'user' => $k,
                'normalisasi' => $normalisasi[$k->id],
                'total' => $total,
            ];
        }

        // 4. sorting
        usort($hasil, fn ($a, $b) => $b['total'] <=> $a['total']);
        // dd($hasil);

        return view('backoffice.assesment-data.assesment.result', compact(['hasil', 'kriteria']));

    }

    public function tes(Request $request)
    {
        $criterias = $this->criteriaRepository->getAll();
        foreach ($criterias as $key => $criteria) {
            $assesment = new Assesment();
            $assesment->user_id = $request->user_id;
            $assesment->criteria_id = $criteria->id;
            $assesment->score = $request->score[$key];
            $assesment->save();
        }
        return redirect()->back()->with('success', 'Penilaian telah ditambahkan');
    }

    public function update(Request $request)
    {
        $user = $this->userRepository->getById($request->user_id);

        foreach ($user->assesments as $assesment) {
            $assesment->score = $request->score[$assesment->criteria_id];
            $assesment->save();
        }
        return redirect()->back()->with('success', 'Penilaian telah diubah');
    }
}
