<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded">
        <!-- Modal Header -->
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title font-weight-bold">
                <i class="fas fa-language mr-2"></i> Hindi Dictionary Suggestion
            </h5>
            <button type="button" id="btn_close_2" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body p-4">
            <!-- Search Keyword Info -->
            <div class="alert alert-light border mb-3 d-flex justify-content-between align-items-center">
                <span><strong>English Name:</strong></span>
                <span class="badge badge-secondary px-3 py-2 font-weight-normal text-md">{{ $name_english }}</span>
            </div>

            <!-- Table Container -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 70%;">Hindi Translation</th>
                            <th style="width: 30%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_result as $value)
                            <tr>
                                <td class="align-middle font-weight-bold text-lg text-primary">
                                    {{ $value->name_l }}
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-success btn-sm px-3 shadow-sm" onclick="EmpNameFill('{{ $value->name_l }}', '{{ $condition_type }}')">
                                        <i class="fas fa-check mr-1"></i> Apply
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-muted py-3">No suggestions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="modal-footer bg-light py-2">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>