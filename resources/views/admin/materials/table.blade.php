<tr data-id="{{ $material->id }}" @if($material->default == 'yes') class="bold-row" @endif>
    <td style="width: 16%;">{{ $material->parent->name }}</td> 
    <td style="width: 14%;">{{ $material->code }}</td> 
    <td style="width: 14%;">{{ $material->color }}</td> 
    <td style="width: 14%;">{{ $material->carat }}@if($material->carat)к@endif</td> 
    <td style="width: 14%;">{{ $material->cash_group }}</td> 
    <td style="width: 14%;">{{ $material->stock_price }}</td> 
    <td style="width: 12%;">
        <span data-url="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="materials" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></span>
        @if($material->id != 1)<span data-url="materials/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> @endif 

        @if(!count($material->quantity) || !count($material->pricesBuy) || !count($material->pricesSell) || !$material->stock_price || !$material->stock_price)
        <button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="
            @if(!count($material->quantity))
                Този материал няма добавена наличност
            @endif

            @if(!count($material->pricesBuy) || !count($material->pricesSell))
                Този материал няма добавени цени
            @endif

            @if(!$material->stock_price)
                Този материал няма добавена борсова цена
            @endif
        "><i class="c-red-500 ti-info-alt"></i></button>
        @endif
    </td>
</tr>