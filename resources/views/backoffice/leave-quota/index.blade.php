@extends('backoffice.layout.main')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Jatah Cuti Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Jatah Cuti</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-outline card-primary mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Filter & Tambah/Update Jatah Cuti Tahunan</h3>
                </div>
                <div class="card-body">
                    <form action="" class="form-inline mb-3">
                        <div class="form-group mr-2">
                            <label for="year" class="mr-2">Tahun</label>
                            <select name="year" class="form-control" required>
                                <option value="">-- Pilih Tahun --</option>
                                @for ($i = 2020; $i <= date('Y') + 2; $i++)
                                    <option value="{{ $i }}" @if ($year == $i) selected @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success mr-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        @if ($year)
                            <a href="/backoffice/leave-quota" class="btn btn-primary">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        @endif
                    </form>
                    <hr>
                    <form method="post" action="{{ route('leave-quota.store') }}" class="row align-items-end">
                        @csrf
                        <div class="form-group col-md-4 mb-2">
                            <label for="user_id">Karyawan</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 mb-2">
                            <label for="year">Tahun</label>
                            <select class="form-control" id="year" name="year" required>
                                @for ($i = 2020; $i <= date('Y') + 2; $i++)
                                    <option value="{{ $i }}" @if ($year == $i) selected @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('year')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 mb-2">
                            <label for="quota">Jatah Cuti (Hari)</label>
                            <input type="number" class="form-control" id="quota" name="quota" min="0" max="365" value="30" required>
                            @error('quota')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-2 mb-2">
                            <button type="submit" class="btn btn-success w-100"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-outline card-info">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">Daftar Jatah Cuti Karyawan Tahun {{ $year ?? date('Y') }}</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tahun</th>
                                    <th>Jatah Cuti</th>
                                    <th>Sudah Diambil</th>
                                    <th>Sisa</th>
                                    <th style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveQuotas as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td class="text-left">{{ $item->user->name ?? '-' }}</td>
                                    <td>{{ $item->year }}</td>
                                    <td class="text-center">{{ $item->quota }}</td>
                                    <td class="text-center">{{ $item->used }}</td>
                                    <td class="text-center">
                                        @php $sisa = $item->quota - $item->used; @endphp
                                        <span class="badge {{ $sisa <= 0 ? 'badge-danger' : 'badge-success' }}" style="font-size:1em;">{{ $sisa }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row flex-nowrap align-items-center justify-content-center" style="gap: 0.5rem;">
                                            <form method="post" action="{{ route('leave-quota.update', $item->id) }}" class="d-flex flex-row flex-nowrap align-items-center" style="gap: 0.25rem;">
                                                @csrf
                                                <div class="input-group input-group-sm" style="width: 130px;">
                                                    <input type="number" name="quota" value="{{ $item->quota }}" min="0" max="365" class="form-control text-center" style="width:55px;" title="Edit jatah cuti">
                                                    <input type="number" name="used" value="{{ $item->used }}" min="0" class="form-control text-center" style="width:55px;" title="Edit cuti terpakai">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary" title="Update data"><i class="fa fa-save"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <a href="{{ route('leave-quota.delete', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')" title="Hapus data"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 