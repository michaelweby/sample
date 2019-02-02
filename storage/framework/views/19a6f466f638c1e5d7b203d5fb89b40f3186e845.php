<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product
            <small>Version 2.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo $__env->make('admin.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Recap Report</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a data-toggle="modal" data-target="#edititem" class="btn btn-warning btn-flat  pull-right">Edit</a>
                        <strong> Name: </strong><a href="<?php echo e(url('dashboard/product/'.$product->id)); ?>"><?php echo e($product->name); ?></a>
                        <br>
                        <hr>

                        <strong> Recommendation: </strong><?php echo e($product->recommendation?'yes':'no'); ?>

                        <br>
                        <hr>

                        <strong> Published: </strong><?php echo e($product->published?'yes':'no'); ?>

                        <br>
                        <hr>

                        <strong> Shop: </strong><a href="<?php echo e(url('dashboard/shop/'.@$product->shop->id)); ?>"><?php echo e(@$product->shop->title); ?></a>
                        <br>
                        <hr>

                        <strong> Description: </strong><?php echo e($product->description); ?>

                        <br>
                        <hr>

                        <strong> Price: </strong><?php echo e($data->price); ?>

                        <br>
                        <hr>

                        <strong> Amount: </strong><?php echo e($data->amount); ?>

                        <br>
                        <hr>

                        <strong> Image: </strong><img src="<?php echo e(url ($data->image)); ?>" class="img-thumbnail"
                                                      style="width:200px">
                        <br>
                        <hr>


                    </div>
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Attributes</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a data-toggle="modal" data-target="#addatribute"
                           class="btn btn-success btn-flat pull-right ">Add Item</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $data->attribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\App\Attribute::find($row->attribute_id)->name); ?></td>
                                    <td><?php echo e($row->value); ?></td>
                                    <td><a data-toggle="modal" data-target="#delete<?php echo e($row->id); ?>"
                                           class="btn btn-danger btn-flat">Delete</a></td>
                                </tr>
                                <div id="delete<?php echo e($row->id); ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Delete Attribute</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><?php echo e('Delete ' . $row->name); ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="<?php echo e(url(PATH.'/deleteattribute/'.$data->id)); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo e(method_field('delete')); ?>

                                                    <input type="hidden" value="<?php echo e($row->id); ?>" name="attr">
                                                    <button type="button" class="btn btn-default btn-flat"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-danger btn-flat">Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div id="addatribute" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post" action="<?php echo e(url(PATH.'/addattribute/'.$data->id)); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Item To <?php echo e($data->name); ?></h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>
                                    <select class="form-control attr12" data="attr">
                                        <?php $__currentLoopData = \App\Attribute::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="0">Select Attribute</option>
                                            <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>
                                    <select class="form-control attr" id="attrvalue" name="attrval[]">
                                        <option value="0">Select Attribute Value</option>
                                    </select>
                                </div>
                            </div>
                            <div id="attr_content"></div>

                                <div class="form-group">
                                    <button type="button" id="addattr" class="form-control btn btn-default btn-flat">Add Attribute
                                    </button>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-flat">Submit</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>


        
        <div id="edititem" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;
                        </button>
                        <h4 class="modal-title">Edit Item</h4>
                    </div>
                    <form method="post" action="<?php echo e(url(PATH.'/edititem/'.$data->id)); ?>" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Price</label>
                                <input type="number" name="price" step=any value="<?php echo e($data->price); ?>" class="form-control"
                                       placeholder="Enter Price">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Amount</label>
                                <input type="number" name="amount" value="<?php echo e($data->amount); ?>" class="form-control"
                                       placeholder="Enter Amount">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Upload Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="image" accept="image" id="imgInp">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <img id='img-upload' src="<?php echo e(url($data->image)); ?>" class="img-thumbnail" style="width: 200px"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat">Submit
                            </button>
                    </div>
                    </form>
                </div>

            </div>
        </div>


        
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function () {
                readURL(this);
            });
        });
    </script>
    <script>
        var count1 = 0;
        $(document).ready(function () {
            function attr1(count) {
                var temp = '<div class="row">' +
                    '            <div class="form-group col-sm-5">' +
                    '                <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>' +
                    '                <select  class="form-control attr12" data="attr' + count + '">' +
                    '                    <?php $__currentLoopData = \App\Attribute::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>' +
                    '<option value="0">Select Attribute</option>' +
                    '                   <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>' +
                    '                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>' +
                    '                </select>' +
                    '            </div>' +
                    '            <div class="form-group col-sm-5">' +
                    '                <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>' +
                    '                <select  class="form-control attr" id="attr' + count + 'value" name="attrval[]">' +
                    '<option value="0">Select Attribute Value</option>' +
                    '                </select>' +
                    '</div>' +
                    '            <div class="form-group col-sm-1">' +
                    '<button type="button" class="form-control btn btn-danger delete_item" style="margin-top:25px">-</button>' +
                    '</div>' +
                    '            </div>';

                return temp;

            }

            $('#addattr').click(function () {
                $('#attr_content').append(attr1(count1));
                count1++;
            });
            $(document).on('click', '.delete_item', function () {
                $(this).parent().parent().remove();
            });
            $(document).on('change', '.attr12', function () {
                var ss = '#' + $(this).attr('data') + 'value';
                $(ss).html('');
                var id = $(this).val();
                var _token = '<?php echo e(csrf_token()); ?>';
                $.ajax({
                    url: "<?php echo e(url(PATH.'/get_attribute_value')); ?>",
                    method: 'post',
                    dataType: 'json',
                    data: {id: id, _token: _token},
                    success: function (data) {
                        console.log(data.length);
                        $(ss).append('<option value="0">Select Attribute Value</option>');
                        for (var i = 0; i < data.length; i++) {
                            $(ss).append('<option value="' + data[i]['id'] + '">' + data[i]['value'] + '</option>');
                        }
                    },
                    error: function () {
                        console.log('error');
                    }
                })
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>