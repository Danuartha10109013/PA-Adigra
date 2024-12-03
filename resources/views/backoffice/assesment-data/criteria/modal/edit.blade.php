<div class="modal fade" id="edit-{{ $criteria->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/assesment-data/criteria/{{ $criteria->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Kriteria <span class="text-danger">*</span></label>
                                <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" placeholder="Nama kriteria" value="{{ $criteria->name }}"
                                required oninvalid="this.setCustomValidity('Nama kriteria harus diisi')" oninput="this.setCustomValidity('')">
                                @if($errors->has('name'))
                                <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Tipe <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" required
                                oninvalid="this.setCustomValidity('Tipe harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih tipe --</option>
                                    <option value="benefit" @if ($criteria->type == 'benefit') selected @endif>Benefit</option>
                                    <option value="cost" @if($criteria->type == 'cost') selected @endif >Cost</option>
                                </select>
                                @if($errors->has('type'))
                                <small class="help-block" style="color: red">{{ $errors->first('type') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Bobot <span class="text-danger">*</span></label>
                                <select name="weight" class="form-control" required
                                oninvalid="this.setCustomValidity('Bobot harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih bobot --</option>
                                    <option value="5" @if ($criteria->weight == '5') selected @endif>Sangat Penting Sekali</option>
                                    <option value="4" @if($criteria->weight == '4') selected @endif >Sangat Penting</option>
                                    <option value="3" @if($criteria->weight == '3') selected @endif >Penting</option>
                                    <option value="2" @if($criteria->weight == '2') selected @endif >Lumayan Tidak Penting</option>
                                    <option value="1" @if($criteria->weight == '1') selected @endif >Tidak Penting</option>
                                </select>
                                @if($errors->has('weight'))
                                <small class="help-block" style="color: red">{{ $errors->first('weight') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-edit"></span> Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>