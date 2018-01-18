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
    }else {

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

    var collectionBtns = document.querySelectorAll('.modal-dialog .modal-footer button[type="submit"]');
    var url = 'http://127.0.0.1:8000/ajax';
    var token = $('meta[name="csrf-token"]').attr('content');
    var form;
    var nameForm
    
    if(collectionBtns.length) {

        collectionBtns.forEach(function(btn){

            btn.addEventListener('click', function(ev) {

                ev.preventDefault();

                form = ev.target.parentElement.parentElement;
                nameForm = form.getAttribute("name");

                var urlAction = form.getAttribute("action"),
                    ajaxUrl = url + urlAction;
                    collectionInputs = document.forms[nameForm].getElementsByTagName("input");
                    collectionSelects = document.forms[nameForm].getElementsByTagName("select");
                    collectionElements = [];
                // TODO: check for radio buttons

                // var collectionElements = document.querySelectorAll('.modal-body .form-control');
                var collectionData = {_token: token};
                
                // Check the inputs

                if(collectionInputs.length != 0) {

                    for(var i=0; i <= collectionInputs.length; i += 1) {

                        var el = collectionInputs[i];

                        if(typeof collectionInputs[i] != 'undefined') {

                            var name = el.getAttribute('name');
                            var value = el.value;
                            collectionData[name] = value;
                            collectionElements.push(collectionInputs[i] );
                        }
                    }
                }

                // Check the selects

                if(collectionSelects.length != 0) {

                    for(var i=0; i <= collectionSelects.length; i += 1) {

                        var el = collectionSelects[i];
                        if(typeof  el != 'undefined') {

                            var name = el.getAttribute('name');

                            if(el.options && el.options[el.selectedIndex]) {

                                var value = el.options[el.selectedIndex].value;
                                collectionData[name] = value;
                                collectionElements.push(collectionSelects[i] );
                            } else {

                                collectionData[name] = '';
                            }
                        }
                    }
                }

                // TODO: GO throug all radio buttons

                // collectionElements.forEach( function(el) {
    
                //     //TODO: to get the elements diff from input 
                //     if(typeof el != null) {
    
                //         var name = el.getAttribute('name');
                //         var value = el.value;
    
                //         collectionData[name] = value;
                //     }
                // });

                ajaxFn('POST', ajaxUrl, handleResponse, collectionData, collectionElements);
            });
        })
    }

    function ajaxFn(method, url, callback, dataSend, elements) {

        var xhttp = new XMLHttpRequest();

        xhttp.open(method , url, true);
        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let data = JSON.parse(this.responseText);
                callback(data, elements); 

            } else if(this.readyState == 4 && this.status == 401) {

                let data = JSON.parse(this.responseText);
                callback(data); 
            }
        };

        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.setRequestHeader("X-CSRF-TOKEN", token);
        xhttp.send(JSON.stringify(dataSend));
    }

    function handleResponse(response, elements) {

        var responseHolder = document.forms[nameForm].firstElementChild;
            responseHolder.innerHTML = "";

        // var errorsHolder = document.getElementById("errors-container");
        //     errorsHolder.innerHTML = "";

        if(response.hasOwnProperty("errors")) {

            var holder = document.createDocumentFragment();
            var errors = response.errors;
            
            for(var err in errors) {

                var collectionErr = errors[err];

                collectionErr.forEach(function(msg) {
                    
                    var errorContainer = document.createElement('div');
                        errorContainer.innerText = msg;
                        errorContainer.className = "alert alert-danger";
                        holder.appendChild(errorContainer);
                })
            }
            responseHolder.appendChild(holder);

        } else {

            var successContainer = document.createElement('div');
                successContainer.innerText = "Успешно добавихте";
                successContainer.className = "alert alert-success";

                responseHolder.appendChild(successContainer);

            elements.forEach(function(el) {
                // TODO: do it for elements diff from input 
                if(typeof el != null) {

                   el.value = "";
                }
            })

            // TODO: to append the information that is returned from the server to the table 
            
        }
    }
});