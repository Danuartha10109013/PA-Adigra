<div class="modal fade" id="notulensi{{ $meet->id }}" tabindex="-1" aria-labelledby="notulensiLabel{{ $meet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="{{ route('meet.notulensi', $meet->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="notulensiLabel{{ $meet->id }}">Tambah Notulensi Meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Notulensi <span class="text-danger">*</span></label>
                        <textarea name="notulensi" class="form-control" rows="5" required>{{ $meet->notulensi }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 