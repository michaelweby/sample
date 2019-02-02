<div class="col-md-12 item" id="item-{{ $item->id }}" data-id ="{{ $item->id }}" >
    <p class="col-md-3">{{ $item->product->name  }}
        <br> Price : {{ $item->price }}
        <br> Stock : {{ $item->amount }}
        <br> Discount : {{ $item->product->discount }} {{ $item->product->discount_type }}

    </p>
    <input name="item_amount[]" value="1" type="number" min="1" max="{{ $item->amount }}" class="amount col-md-3" data-price="{{ $item->price }}" data-target="{{ $item->id }}">
    <input name="item_id[]" value="{{ $item->id }}" class="item-id" type="hidden">
    <span class="col-md-3">Total : <span class="total" data-reference="{{ $item->id }}">{{ $item->price }}</span></span>
    <span class="remove-item" style="cursor: pointer" data-id="{{ $item->id }}"><i class="fa fa-fw fa-close text-red"></i></span>
</div>
