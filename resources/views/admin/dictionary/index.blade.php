@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Dictionary Management</h3>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">                                       
            <div class="row">
                <div class="col-lg-5">                       
                    <div class="form-group">
                        <label>Name (English)</label>
                        <span class="fa fa-asterisk text-danger"></span>
                        <input type="text" name="name_e" id="name_e" class="form-control" maxlength="100" placeholder="Enter Name English" onkeypress='return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32)'>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <label>Name (हिंदी) <small class="text-muted">(Press F2 for Suggestions)</small></label>
                        <input type="text" name="name_l" id="name_l" class="form-control" maxlength="100" placeholder="Hindi name">
                    </div>
                </div>
                <div class="col-lg-2 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button type="button" id="btn_save_dictionary" class="btn btn-success btn-block">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>
                </div>
            </div>     
        </div>
    </div> 
</section>
@endsection

@push('scripts')
<script>
    // Helper function to fetch and auto-fill local language name on Tab key
    function fetchHindiName(englishInputId, hindiInputId, type) {
        var englishName = $(englishInputId).val().trim();
        var existingHindiName = $(hindiInputId).val().trim();

        if (englishName.length === 0 || existingHindiName.length > 0) {
            return;
        }

        $.ajax({
            url: '{{ route("admin.dictionary.fetchHindiName", "") }}/' + type,
            type: 'GET',
            data: { name_english: englishName },
            success: function(response) {
                if (response && response.hindi_name) {
                    $(hindiInputId).val(response.hindi_name);
                }
            },
            error: function(xhr) {
                console.log("Error fetching local language name");
            }
        });
    }

    // Tab key event on English input
    $('#name_e').on('keydown', function(event) {
        if (event.keyCode === 9) {
            fetchHindiName('#name_e', '#name_l', 1);
        }
    });

    // F2 key (key.which == 113) on Hindi input for popup dictionary suggestions
    $("#name_l").keyup(function(event) {
        if (event.which == 113) {
            var englishVal = $("#name_e").val().trim();
            if (englishVal.length === 0) {
               alert('Please Enter Name English first.');
               $("#name_e").focus();
            } else {
               callPopupLarge(this, '{{ route('admin.dictionary.correctHindiName', 1) }}' + '?name_english=' + encodeURIComponent(englishVal));    
            }
        }
    });

    // Apply button click handler from popup modal
    function EmpNameFill(val, con_type) {
        if (con_type == 1) {
            $("#name_l").val(val);
        }
        $("#btn_close_2").click();

        // Modal se apply hone par automatically dictionary me save/update call ho jayega
        saveDictionaryData($("#name_e").val(), val);
    }

    // Save Button Click Event
    $('#btn_save_dictionary').click(function() {
        var englishName = $('#name_e').val().trim();
        var hindiName = $('#name_l').val().trim();

        if (englishName === '') {
            alert('Please enter English Name.');
            $('#name_e').focus();
            return;
        }

        if (hindiName === '') {
            alert('Please enter Hindi Name.');
            $('#name_l').focus();
            return;
        }

        saveDictionaryData(englishName, hindiName);
    });

    // Ajax function to send data to Controller
    function saveDictionaryData(englishName, hindiName) {
        $.ajax({
            url: '{{ route("admin.dictionary.saveOrUpdateDictionary") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name_e: englishName,
                name_l: hindiName
            },
            success: function(response) {
                if (response.status) {
                    // Aap chahein toh toastr notification ya simple alert use kar sakte hain
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Something went wrong while saving to dictionary.');
            }
        });
    }
</script>
@endpush