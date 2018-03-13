var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window);

    this.init = function () {
      $self.initializeSelect($('select'));
      $self.addAndRemoveFields($('form[name="addModel"]'));
      $self.checkAllForms();
    };

    this.initializeSelect = function (select) {

      select.select2();
    }

    //todo: refactor when it's starts being used for another form, so it's not hardcoded
    this.addAndRemoveFields = function (form) {
      form.each(function() {
        var currentForm = $(this),
          maxFields = 10,
          addButton = currentForm.find('.add_field_button'),
          fields = currentForm.find('.fields'),
          fieldsWrapper = currentForm.find('.model_stones'),
          stonesData = $('#stones_data').length > 0 ? JSON.parse($('#stones_data').html()) : null;


        //Add Fields
        addButton.on('click', function (e) {
          e.preventDefault();

          if (fields.length <= maxFields) {
            var fieldsHolder = document.createElement('div');
            fieldsHolder.classList.add('form-row', 'fields');

            var newFields =
              '<div class="form-group col-md-6">' +
              '<label>Камък:</label>' +
              '<select name="stones[]" class="form-control">';

            stonesData.forEach(function (option) {
              newFields += `<option value=${option.value}>${option.label}</option>`
            })

            newFields +=
              '</select>' +
              '</div>' +
              '<div class="form-group col-md-6">' +
              '<label>Брой:</label>' +
              '<input type="text" class="form-control" name="stone_amount[]" placeholder="Брой">' +
              '</div>';

            fieldsHolder.innerHTML = newFields;
            fieldsWrapper.append(fieldsHolder);

            $self.initializeSelect(fieldsWrapper.find('select'));
          }
        });

        //Remove Fields
        $(fieldsWrapper).on('click', '.remove_field', function () {
          e.preventDefault();
          $(this).parent().remove();
        })
      })
    }

    this.checkAllForms = function() {

      var collectionBtns = document.querySelectorAll('.modal-dialog .modal-footer button[type="submit"]');
      var urlTaken = window.location.href.split('/');
      var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
      var token = $('meta[name="csrf-token"]').attr('content');
      var form;
      var nameForm;

      var collectionModelPrice = [].slice.apply(document.querySelectorAll('.calculate'));

      if (collectionModelPrice.length) {

        var typeJewery = collectionModelPrice[0]
        var price = collectionModelPrice[1];
        var weight = collectionModelPrice[2];

        collectionModelPrice.forEach(function (el) {

          if(el.tagName === 'SELECT') {

            $(el).on('select2:select', function(e) {

              calculatePrice();
            })

          } else {

            el.addEventListener('change', function (ev) {

              calculatePrice();
            });
          }
        });
      }

      if (collectionBtns.length) {

        var modelSelect = $('#model_select');
        var typeSelect;

        if(modelSelect) {

          modelSelect.on('select2:select', function(ev) {

            if(modelSelect.val()) {
              
              var value = modelSelect.find(':selected').data('jewel'),
                  tempUrl = url + '/products/' + value,
                  xhttp = new XMLHttpRequest(),
                  typeSelect = $('#jewels_types');

              typeSelect.on('select2:select', function(ev) {

                var valueSelect = typeSelect.val();
                var urlType = url + '/products/' + 1//valueSelect;

                productsRequest(urlType);
                modelSelect.val('0');
              })

              productsRequest(tempUrl);
            }
          });
        }
          
        collectionBtns.forEach(function (btn) {

          btn.addEventListener('click', function (ev) {

            ev.preventDefault();

            form = ev.target.parentElement.parentElement;
            nameForm = form.getAttribute('name');

            var urlAction = form.getAttribute('action'),
              formMethod = 'POST',
              ajaxUrl = url + urlAction;
              collectionInputs = [].slice.apply(document.forms[nameForm].getElementsByTagName('input'));
              collectionSelects = [].slice.apply(document.forms[nameForm].getElementsByTagName('select'));
              collectionElements = [];

            var collectionData = {_token: token};

            // Check the inputs

            if (collectionInputs.length != 0) {

              collectionInputs.map(function (el) {

                if (el != 'undefined') {

                  var name = el.getAttribute('name');
                  var value = el.value;
                  var elType = el.getAttribute('type');

                  if (name === '_method') {

                    formMethod = value;
                  }

                  if (elType === 'checkbox') {

                    collectionData[name] = el.checked;

                  } else if (name.includes('[]')) {

                    name = name.replace('[]', '');

                    if (collectionData.hasOwnProperty(name)) {

                      collectionData[name].push(value);

                    } else {

                      collectionData[name] = [value];
                    }

                  } else {

                    collectionData[name] = value;
                    collectionElements.push(el);
                  }
                }
              });
            }

            // Check the selects

            if (collectionSelects.length != 0) {

              for (var i = 0; i <= collectionSelects.length; i += 1) {

                var el = collectionSelects[i];

                if (typeof  el != 'undefined') {

                  var name = el.getAttribute('name');
                  var value;

                  if (el.options && el.options[el.selectedIndex]) {

                    value = el.options[el.selectedIndex].value;

                  } else {

                    value = '';
                  }

                  if (name.includes('[]')) {

                    name = name.replace('[]', '');

                    if (collectionData.hasOwnProperty(name)) {

                      collectionData[name].push(value);
                    } else {

                      collectionData[name] = [value];
                    }
                  } else {


                    collectionData[name] = value;
                    collectionElements.push(collectionSelects[i]);
                  }
                }
              }
            }

            if (formMethod == 'POST') {

              ajaxFn(formMethod, ajaxUrl, handleResponsePost, collectionData, collectionElements);

            } else if (formMethod == 'PUT') {

              ajaxFn(formMethod, ajaxUrl, handleUpdateResponse, collectionData, collectionElements);
            }
          });
        })
      }
      
      function productsRequest(tempUrl) {

        var xhttp = new XMLHttpRequest();

        xhttp.open('GET', tempUrl, true);
        xhttp.onreadystatechange = function () {

          if (this.readyState == 4 && this.status == 200) {

            var data = JSON.parse(this.responseText);

            for(var key in data) {

              var holder = document.getElementById(key);

              if(holder) {

                var tagName = holder.tagName.toLowerCase();

                switch (tagName) {

                  case 'input':

                    holder.value = data[key];
                    break;

                  case 'select':

                    var collectionData = data[key];
                    
                    for(i = holder.options.length - 1 ; i >= 1 ; i--){
                    
                      holder.remove(i);
                    }

                    collectionData.map(function(el) {
                      

                      var option = document.createElement('option');
                          option.text = el.label;
                          option.value = el.value;
                          
                      if(el.hasOwnProperty('selected') && el['selected']) {

                        option.selected = true;
                      }

                      holder.add(option);
                    })

                    break;

                  case 'span':

                    holder.innerText = data[key];
                    break;

                  default:
                    console.log("something went wrong");
                    break;
                }
              }
            }
          }
        };

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xhttp.send();
      }

      function calculatePrice() {

        var typeJeweryData = typeJewery.options[typeJewery.selectedIndex].getAttribute('data-pricebuy'),
          priceData = price.options[price.selectedIndex].getAttribute('data-retail'),
          weightData = weight.value;

        var inputDev = document.getElementById('inputDev'),
          inputPrice = document.getElementById('inputPrice');

        if (typeJeweryData && priceData && weightData) {

          var priceDev = (priceData - typeJeweryData) * weightData;
          var productPrice = (priceData * weightData);

          inputDev.value = priceDev;
          inputPrice.value = productPrice;

        } else {

          inputDev.value = '0';
          inputPrice.value = '0';
        }
      }

      function ajaxFn(method, url, callback, dataSend, elements) {

        var xhttp = new XMLHttpRequest();

        xhttp.open(method, url, true);
        xhttp.onreadystatechange = function () {

          if (this.readyState == 4 && this.status == 200) {

            var data = JSON.parse(this.responseText);

            callback(data, elements);

          } else if (this.readyState == 4 && this.status == 401) {

            var data = JSON.parse(this.responseText);

            callback(data);
          }
        };

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xhttp.send(JSON.stringify(dataSend));
      }

      function handleResponsePost(response, elements) {

        var responseHolder = document.forms[nameForm].firstElementChild.firstElementChild;
        responseHolder.innerHTML = '';

        if (response.hasOwnProperty('errors')) {

          var holder = document.createDocumentFragment();
          var errors = response.errors;

          for (var err in errors) {

            var collectionErr = errors[err];

            collectionErr.forEach(function (msg) {

              var errorContainer = document.createElement('div');
              errorContainer.innerText = msg;
              errorContainer.className = 'alert alert-danger';
              holder.appendChild(errorContainer);
            })
          }
          responseHolder.appendChild(holder);

        } else {

          var successContainer = document.createElement('div');
              successContainer.innerText = 'Успешно добавихте';
              successContainer.className = 'alert alert-success';

          responseHolder.appendChild(successContainer);

          if (nameForm === 'addPrice') {

            var select = collectionSelects[0];
            var tableId = document.querySelector('#' + select.options[select.selectedIndex].value + ' tbody');

            tableId.innerHTML += response.success;

          } else {
            var tableBody = document.querySelector('table.table tbody');
            tableBody.innerHTML += response.success;
          }

          elements.forEach(function (el) {

            var elType = el.getAttribute('type');

            if (typeof el != null && elType !== 'hidden') {

              el.value = '';
            }
          })
        }
      }

      function handleUpdateResponse(data, elements) {

        var content = data.table.replace('<tr>', '').replace('</tr>', '');
        var tableRow = currentPressedBtn.parentElement.parentElement;

        tableRow.innerHTML = content;
      }
    }

    // adding functionality to the eddit buttons
    // Todo: response of the action: handle the errors and also refactor the hardcoded holder
    this.editAction = function() {

      var currentPressedBtn;
      var collectionEditBtns = [].slice.apply(document.querySelectorAll('.edit-btn'));

      collectionEditBtns.forEach(function (btn) {

        var path = btn.dataset.path;

        btn.addEventListener('click', function () {

          currentPressedBtn = this;

          var urlTaken = window.location.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax/' + path;
          var xhttp = new XMLHttpRequest();

          xhttp.open('GET', url, true);
          xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

              var data = JSON.parse(this.responseText);
              // callback(data, elements);
              var holder = document.querySelector('#editStore .modal-content');
              holder.innerHTML = '';
              holder.innerHTML += data.success;

            } else if (this.readyState == 4 && this.status == 401) {

              var data = JSON.parse(this.responseText);
              // callback(data);

              console.log(data);
            }
          };

          xhttp.setRequestHeader('Content-Type', 'application/json');
          xhttp.send();

          setTimeout(
            function () {

              checkAllForms()
            }
            , 600);
        });
      });
    }


  };

$(function () {
  if (!window.console) window.console = {};
  if (!window.console.log) window.console.log = function () {
  };
  if (!window.console.info) window.console.info = function () {
  };

  uvel = new uvelController();
  uvel.init();
});

//todo: IN PROGRESS refactor this in RBD WAY
$(document).ready(function () {

  // Gosho's creation ! extra attention :D 

    var select_input = $('#jewel');
    var disabled_input = $('.disabled-first');

    if ($(this).find(':checked').val() != '') {

      disabled_input.removeAttr('disabled');

    } else {

      disabled_input.prop('disabled', true);
      disabled_input.prop('selectedIndex', 0);
    }

    select_input.on('change', function () {

      if ($(this).find(':checked').val() != '') {

        disabled_input.removeAttr('disabled');
      } else {

        disabled_input.prop('disabled', true);
        disabled_input.prop('selectedIndex', 0);
      }

      var val = $(this).find(':checked').data('price');

      $('option[data-material]').hide();
      $('option[data-material="' + val + '"]').show();
    });

    var select_stone_type = $('select#stone_type');

    select_stone_type.on('change', function () {
      $('#weight').val('');
      $('#carat').val('0');
    });

    $('#weight').focusout(function () {

      if ($(select_stone_type).find(':checked').val() == 2) {

        $('#carat').val($(this).val() * 5);
      }
    });
  
  // end of G.'s creation  
});