<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="example">
                <thead class="thead-dark">
                    <tr>
                        <th>Sr. No.</th>                
                        <th>Name (English)</th>
                        <th>Name (Hindi)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sr_no = 1;
                    @endphp
                    @foreach($rs_result as $value)
                        <tr>
                            <td>{{ $sr_no++ }}</td>
                            <td>{{ $value->name_e }}</td>
                            <td>{{ $value->name_l }}</td>
                            <td>
                                {{-- @if($value->verified == 0) --}}
                                    <button type="button" class="btn btn-sm btn-success" button-click="btn_show_dictionary" success-popup="true" onclick="if (confirm('Are you sure you want to verify this dictionary entry?')) {callAjax(this,'{{ route('admin.dictionary.verify.update', Crypt::encrypt($value->id)) }}')}else{console_Log('cancel')}"> Verify</button>
                                {{-- @else --}}

                                    <button type="button" class="btn btn-sm btn-danger" button-click="btn_show_dictionary" success-popup="true" onclick="if (confirm('Are you sure you want to delete this dictionary entry?')) {callAjax(this,'{{ route('admin.dictionary.verify.delete', Crypt::encrypt($value->id)) }}')} else {console_Log('cancel')}"> Delete</button>
                                {{-- @endif --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>