@extends('admin.master')
@section('content')
    <div class="col-md-12 ">
        <div class="panel panel-primary">
            <div class="panel-heading">You can Upload CSV from here</div>
            <div class="panel-body">

                <form method="POST" action="{{ secure_url(PATH.'/import-csv-excel') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <select name="model" class="form-control" required>
                                        <option disabled="" selected>Choose where to add!!</option>
                                        <option value="user">User</option>
                                        <option value="product">Product</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <label>Select File to Import</label>
                                    <input type="file" name="csv" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-bitbucket">upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
