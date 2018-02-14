var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window);

    this.init = function () {
      $self.initializeSelect($('select'));
      $self.addAndRemoveFields($('form[name="addModel"]'));
    };

    this.initializeSelect = function (select) {
      select.select2();
    }

    //todo: refactor when it's starts being used for another form, so
    this.addAndRemoveFields = function (form) {
      var maxFields = 10,
          addButton = $(form[0]).find('.add_field_button'),
          fields = $(form[0]).find('.fields'),
          fieldsWrapper = $(form[0]).find('.model_stones'),
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


$(document).ready(function () {
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

  checkAllForms();

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

  function checkAllForms() {

    var collectionBtns = document.querySelectorAll('.modal-dialog .modal-footer button[type="submit"]');
    var urlTaken = window.location.href.split('/');
    var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
    var token = $('meta[name="csrf-token"]').attr('content');
    var form;
    var nameForm

    var collectionModelPrice = document.querySelectorAll('.calculate');

    if (collectionModelPrice.length) {

      var typeJewery = collectionModelPrice[0];
      var price = collectionModelPrice[1];
      var weight = collectionModelPrice[2];

      collectionModelPrice.forEach(function (el) {

        el.addEventListener('change', function (ev) {

          var typeJeweryData = typeJewery.options[typeJewery.selectedIndex].getAttribute('data-pricebuy'),
            priceData = price.options[price.selectedIndex].getAttribute('data-retail'),
            weightData = weight.value;

          var priceDevTag = document.getElementById('priceDev'),
            inputDev = document.getElementById('inputDev'),
            priceTag = document.getElementById('price'),
            inputPrice = document.getElementById('inputPrice');

          if (typeJeweryData && priceData && weightData) {

            var priceDev = (priceData - typeJeweryData) * weightData;
            var productPrice = (priceData * weightData);

            priceDevTag.innerText = priceDev;
            priceTag.innerText = productPrice;

            inputDev.value = priceDev;
            inputPrice.value = productPrice;

          } else {

            priceDevTag.innerText = '0';
            priceTag.innerText = '0';
            inputDev.value = '0';
            inputPrice.value = '0';
          }
        });
      })
    }

    if (collectionBtns.length) {

      collectionBtns.forEach(function (btn) {

        btn.style.border = '1px solid yellow';

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

    function ajaxFn(method, url, callback, dataSend, elements) {

      var xhttp = new XMLHttpRequest();

      xhttp.open(method, url, true);
      xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

          var data = JSON.parse(this.responseText);
          console.log(data);
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
          console.log(tableId);
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
});