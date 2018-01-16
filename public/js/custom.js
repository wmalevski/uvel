$(document).ready(function() {
    var max_fields      = 10; 
    var wrapper         = $('.model-stones'); 
    var add_button      = $('.add_field_button'); 
    
    var x = 1; 
    $(add_button).click(function(e) { 
        e.preventDefault();
        if(x < max_fields) { 
            x++;
            $('.model-stones .fields').clone().appendTo(wrapper); 
        }
    });
    
    $(wrapper).on('click', '.remove_field', function(e) { 
        e.preventDefault(); 
        $(this).parent('div').remove(); 
        x--;
    });

    var select_input = $('#jewel');
    var disabled_input = $('.disabled-first');

    if($(this).find(':checked').val() != '') {
        disabled_input.removeAttr('disabled');
    }else{
        disabled_input.prop('disabled', true);
        disabled_input.prop('selectedIndex', 0);
    }

    select_input.on('change', function() {
        if($(this).find(':checked').val() != '') {
            disabled_input.removeAttr('disabled');
        }else{
            disabled_input.prop('disabled', true);
            disabled_input.prop('selectedIndex', 0);
        }

        var val = $(this).find(':checked').data('price');
        $('option[data-material]').hide();
        $('option[data-material="' + val + '"]').show();
    });

    var select_stone_type = $('select#stone_type');

    select_stone_type.on('change', function() {
        $('#weight').val('');
        $('#carat').val('0');
    });

    $('#weight').focusout(function() {
        if($(select_stone_type).find(':checked').val() == 2) {
            $('#carat').val($(this).val()*5);
        }
    });
});