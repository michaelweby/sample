$(document).ready(function () {
    var count=0;
    function html(count1) {
        var temp= '<div>'+
            ' <div class="form-group">' +
            '            <div class="form-group col-sm-6">' +
            '                <label for="inputPassword3" class=" control-label">Price</label>' +
            '                <input type="number" name="price1['+count1+']" class="form-control"  placeholder="Price">' +
            '            </div>' +
            '            <div class="form-group col-sm-6">' +
            '                <label for="inputPassword3" class=" control-label">Amount</label>' +
            '                <input type="number" name="count['+count1+']" class="form-control"  placeholder="Amount">' +
            '            </div>' +
            '     <div class="form-group col-sm-4">' +
            '                                        <label>Upload Image</label>' +
            '                                        <div class="input-group">' +
            '                                    <span class="input-group-btn">' +
            '                                        <span class="btn btn-default btn-file">' +
            '                                            Browse… <input type="file" name="images['+count1+']" accept="image"' +
            '                                                           class="imgInp" data="'+count1+'">' +
            '                                        </span>' +
            '                                    </span>' +
            '                                            <input type="text" class="form-control" readonly>' +
            '                                        </div>' +
            '                                        <img class="img-thumbnail img-upload'+count1+'" style="width: 200px"/>' +
            '                                    </div>'+
            '   <div class="form-group col-sm-8" style="border: solid 2px green;margin-top:5px ">' +
            '<div id="attr'+count1+'content" class="form-group">' +
            '<h3>Item Attribute</h3>'+
            '</div>'+
            '                                        <div class="form-group col-md-12" data="'+count1+'">' +
            '                                            <span id="contacts"></span>' +
            '                                            <button type="button" class="btn btn-primary btn-flat addattribute" data="attr'+count1+'">Add Attribute</button>\n' +
            '                                        </div>'+
            '                                        </div>' +

            '  <div class="col-md-6 pull-right" style="margin-top:7px">' +
            '<button type="button" class="btn  btn-danger  delete">Delete Item</button>'+
            '</div>'+
            '<div class="form-group col-md-12" style="border: dashed 1px gainsboro;margin-top: 7px"></div>'+
            '        </div>' ;
        return temp;
    }

    $('#addhtml').click(function () {
        count++;
        $('#attr').append(html(count));
    });
    $(document).on('click','.delete',function () {
        console.log('clicked');
        $(this).parent().parent().remove();
    })


    function attr1(index,index2) {
        var temp='<div class="row form-group">'+
            '            <div class="form-group col-sm-5">' +
            '                <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>' +
            '                <select  class="form-control attr12" data="attr'+index+index2+'">' +
            '<option value="0">Select Attribute</option>'+
            '                    @foreach(\App\Attribute::get() as $row)' +
            '                   <option value="{{ $row->id }}">{{ $row->name }}</option>' +
            '                        @endforeach' +
            '                </select>' +
            '            </div>'+
            '            <div class="form-group col-sm-5">' +
            '                <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>' +
            '                <select  class="form-control attr" id="attr'+index+index2+'value" name="attrval['+index+'][]">' +
            '<option value="0">Select Attribute Value</option>'+
            '                </select>' +
            '</div>'+
            '            <div class="form-group col-sm-1">' +
            '<button type="button" class="form-control btn btn-danger delete_item" style="margin-top:25px">-</button>'+
            '</div>'+
            '            </div>';

        return temp;

    }
    var count2=0;
    $(document).on('click','.addattribute',function(){
        var index=$(this).parent().attr('data');
        $('#'+$(this).attr('data')+'content').append(attr1(index,count2));
        count2++;
    });
    $(document).on('click','.delete_item',function(){
        $(this).parent().parent().remove();
    });
})
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
        console.log('.'+$(input).attr('data'));
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img-upload'+$(input).attr('data')).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('change','.imgInp',function () {
        readURL(this);
    });
    $(document).on('change','.attr12',function () {
        var ss='#'+$(this).attr('data')+'value';
        $(ss).html('');
        var id=$(this).val();
        var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{ url(PATH.'/get_attribute_value') }}",
            method: 'post',
            dataType: 'json',
            data: {id: id, _token: _token},
            success: function (data) {
                console.log(data.length);
                $(ss).append('<option value="0">Select Attribute Value</option>');
                for(var i=0;i<data.length;i++)
                {
                    $(ss).append('<option value="'+data[i]['id']+'">'+data[i]['value']+'</option>');
                }
            },
            error:function () {
                console.log('error');
            }
        })
    });
});