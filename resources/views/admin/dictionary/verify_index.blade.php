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
        <form  class="add_form" method="post" action="{{ route('admin.dictionary.verify.show') }}" success-content-id="result_div_id" no-reset="true"> 
            {{ csrf_field() }}                                      
            <div class="row">
                <div class="col-lg-6">                       
                    <div class="form-group">
                        <label>Input Option</label>
                        <span class="fa fa-asterisk text-danger"></span>
                        <input type="text" name="input_value" id="input_value" class="form-control" maxlength="100">
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button type="submit" id="btn_show_dictionary" class="btn btn-success btn-block">
                            <i class="fas fa-search mr-1"></i> Show
                        </button>
                    </div>
                </div>
            </div>     
        </div>
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div class="row" id="result_div_id"> 

            </div>    
        </div>
    </div> 
</section>
@endsection