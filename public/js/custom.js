var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window),
      currentPressedBtn;

    this.init = function () {
      $self.initializeSelect($('select'));
      $self.addAndRemoveFields($('form[name="addModel"]'));
      $self.checkAllForms();
      this.editAction();
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
            });

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

    this.dropFunctionality = function(instanceFiles) {
      var dropArea = document.getElementById("drop-area");
      var input = document.getElementById("fileElem");
      var preventEvents = ['dragenter', 'dragover', 'dragleave', 'drop'],
          highlightEvents = ['dragenter', 'dragover'],
          unhighlightEvents = ['dragleave', 'drop'];

      input.addEventListener('change', function(ev) {
        var files = ev.target.files,
            collectionFiles= [];

        for(var file of files) {
          collectionFiles.push(file);
        }

        handleFiles(collectionFiles);
      })

      preventEvents.forEach(function(eventName) {
        dropArea.addEventListener(eventName, preventDefaults, false);
      }); 
      
      highlightEvents.forEach(function(eventName) {
        dropArea.addEventListener(eventName, highlight, false);
      });

      unhighlightEvents.forEach(function(eventName) {
        dropArea.addEventListener(eventName, unhighlight, false);
      });
      
      dropArea.addEventListener('drop', handleDrop, false);

      function highlight(e) {
        dropArea.classList.add('highlight');
      }
      
      function unhighlight(e) {
        dropArea.classList.remove('highlight');
      }

      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      } 

      function handleDrop(e) {
        var dt = e.dataTransfer,
            files = dt.files,
            collectionFiles= [];

        for(var file of files) {
          collectionFiles.push(file);
        }

        handleFiles(collectionFiles);
      }

      function handleFiles(files) {
        files.forEach(previewFile);
      }

      function previewFile(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onloadend = function() {
          var img = document.createElement('img');
          img.src = reader.result;
          document.getElementById('gallery').appendChild(img);

          toDataURL(
            reader.result,
            function(dataUrl) {
              var data = dataUrl.replace('data:image/png;base64,','');
              instanceFiles.push(data);
            }
          )
        }
      }

      function toDataURL(src, callback, outputFormat) {
        var img = new Image();
        img.crossOrigin = 'Anonymous';

        img.onload = function() {
          var canvas = document.createElement('CANVAS');
          var ctx = canvas.getContext('2d');
          var dataURL;
          canvas.height = this.naturalHeight;
          canvas.width = this.naturalWidth;
          ctx.drawImage(this, 0, 0);
          dataURL = canvas.toDataURL(outputFormat);
          callback(dataURL);
        };

        img.src = src;
        if (img.complete || img.complete === undefined) {
          img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
          img.src = src;
        }
      } 
    }

    this.checkAllForms = function(currentPressedBtn) {

      var collectionBtns = document.querySelectorAll('.modal-dialog .modal-footer button[type="submit"]');
      var deleteBtns = document.querySelectorAll('.delete-btn');

      var urlTaken = window.location.href.split('/');
      var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
      var token = $('meta[name="csrf-token"]').attr('content');
      var form;
      var nameForm;
      var numberItemInput = document.getElementById("number_item");
      var amountInput =  document.getElementById("amount");

      var sellingForm = document.getElementById('selling-form');

      var collectionModelPrice = [].slice.apply(document.querySelectorAll('.calculate'));
      var collectionFillFields = [].slice.apply(document.querySelectorAll('.fill-field'));

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

      if(collectionFillFields.length) {
        collectionFillFields.map(function(el) {
          if(el.tagName === 'SELECT') {
            $(el).on('select2:select', function(e) {
              var fieldToFill = el.dataset.fieldtofill,
                  valueToBeSet = $(el).find('option:selected').data('price');

              fillValue(fieldToFill, valueToBeSet);
            })
          }
        })
      }

      if (collectionBtns.length) {
        var modelSelect = $('#model_select');
        var typeSelect;
        var collectionFiles = [];
        var dropZone = document.getElementById("drop-area");

        if(dropZone) {
          this.dropFunctionality(collectionFiles);
          // Todo: make a removing functionality
         
        }

        if(modelSelect) {
          modelSelect.on('select2:select', function(ev) {
            if(modelSelect.val()) {
              var value = modelSelect.find(':selected').val(),
                  tempUrl = url + '/products/' + value,
                  xhttp = new XMLHttpRequest(),
                  typeSelect = $('#jewels_types');

              typeSelect.on('select2:select', function(ev) {
                modelSelect.val('0').trigger('change.select2');
              });

              productsRequest(tempUrl);
            }
          });
        }
          
        collectionBtns.forEach(function (btn) {
          btn.removeEventListener('click', getFormData, true);
          btn.addEventListener('click', getFormData);
        })
      }

<<<<<<< HEAD

    if(sellingForm !== null){
      
      sellingForm.onsubmit = function(e){
          e.preventDefault();
      };

    }

    if(numberItemInput !== null){
      numberItemInput.onchange = sendItem;
    }
=======
      if(numberItemInput !== null){
        numberItemInput.onchange = sendItem;
      }
>>>>>>> d913ea07ba678473daecaa2fdc1a83b7b9fcb1a6

     function sendItem(event) {

         var numberItemValue = this.value;
         var amountValue = amountInput.value;

         if(numberItemValue.length == 13){
        
           var dataSend = {'barcode' : Number(numberItemValue), 'quantity' : Number(amountValue)};
  
           var currentElement = $(event.target);
           var form = currentElement.closest("form");
           var ajaxUrl = form.attr("data-scan");

           ajaxFn("POST", ajaxUrl, sendSuccess, dataSend, '', '');

         }

     }

      function sendSuccess(data, elements, btn){

        var html = $.parseHTML(data.table);
        var shoppingTable = $("#shopping-table");

        shoppingTable.append(html);
        
      }

      document.addEventListener('click', deleteRowRecord);


      function deleteRowRecord(event) {
              
        if(event.target && event.target.parentElement.classList.contains('delete-btn')) {

          event.preventDefault();
          event.stopPropagation();

          if (confirm("Сигурен ли си, че искаш да изтриеш записа?")) {

            var urlTaken = event.target.parentElement.href.split('/');
            var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
    
            let link = event.target.parentElement;
            let linkPath = link.href.split("admin")[1];
            let ajaxUrl = url+linkPath;

            ajaxFn('PОST',ajaxUrl,deleteBtnSuccess,' ',' ',link);

          }       
        }
      }



      function deleteBtnSuccess(data, elements, btn) {

       
        let td = btn.parentElement;
        let tr = td.parentElement;
        let table = tr.parentElement;

        table.removeChild(tr);  
        
       
      }

      function getFormData(event) {

        var evt = event || window.event;

        evt.preventDefault();

       form = evt.target.parentElement.parentElement;

  
       nameForm = form.getAttribute('name');

        var urlAction = form.getAttribute('action'),
          formMethod = 'POST',
          ajaxUrl = url + urlAction;
          collectionInputs = [].slice.apply(document.forms[nameForm].getElementsByTagName('input'));
          collectionTextareas = [].slice.apply(document.forms[nameForm].getElementsByTagName('textarea'));              
          collectionSelects = [].slice.apply(document.forms[nameForm].getElementsByTagName('select'));
          collectionElements = [];

        var collectionData = {_token: token};

        // Check the inputs

        if (collectionInputs.length != 0) {
          collectionInputs.map(function (el) {
            if (el != 'undefined') {
              var name = el.getAttribute('name');
              var elType = el.getAttribute('type');              
              var value = elType === 'checkbox' ? el.checked : el.value;

              if(name === 'images') {
                collectionData[name] = [].slice.apply(collectionFiles);
                return true;
              } else if (name.includes('[]')) {
                name = name.replace('[]', '');

                if (collectionData.hasOwnProperty(name)) {
                  collectionData[name].push(value);

                } else {
                  collectionData[name] = [value];
                }
              } else {
                if (name === '_method') {
                  formMethod = value;
                }
                
                collectionData[name] = value;
                collectionElements.push(el);
              }
            }
          });
        }

        // Check the textareas

        if(collectionTextareas.length) {
          collectionTextareas.map(function(el) {
              if(el != 'undefined') {
                var name = el.getAttribute('name');
                var value = el.value;

                collectionData[name] = value;
                collectionElements.push(el);
              }
          })
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
          ajaxFn(formMethod, ajaxUrl, handleResponsePost, collectionData, collectionElements, currentPressedBtn);
        } else if (formMethod == 'PUT') {
          ajaxFn(formMethod, ajaxUrl, handleUpdateResponse, collectionData, collectionElements, currentPressedBtn);
        }
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
                    });

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

      function fillValue(el, value) {
          if(typeof(value) == 'undefined') {
            value = '';
          }
          
          document.querySelector(el).value = value;
      }

      function ajaxFn(method, url, callback, dataSend, elements, currentPressedBtn) {
        var xhttp = new XMLHttpRequest();

        xhttp.open('POST', url, true);
        xhttp.onreadystatechange = function () {

          if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            callback(data, elements, currentPressedBtn);
          } else if (this.readyState == 4 && this.status == 401) {
            var data = JSON.parse(this.responseText);
            callback(data);
          }
        };

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xhttp.send(JSON.stringify(dataSend));
      }

     

      function handleResponsePost(response, elements, currentPressedBtn) {
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
            });
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
            if(nameForm === 'addRepair') {
              var repairId = response.id,
                  certificateButton = document.querySelector('button#certificate');

              certificateButton.dataset.repairId = repairId;
              certificateButton.disabled = false;
            }

            var tableBody = document.querySelector('table.table tbody');
            tableBody.innerHTML += response.success;
          }

          elements.forEach(function (el) {
            var elType = el.getAttribute('type');

            if (typeof el != null && elType !== 'hidden' && typeof(el.dataset.clear) == 'undefined') {
              if(elType == 'checkbox') {
                el.checked = false;
              }
              
              el.value = '';
            }
          })
        }
      }

      function handleUpdateResponse(data, elements, currentPressedBtn) {
        console.log($self.currentPressedBtn);
        var content = data.table.replace('<tr>', '').replace('</tr>', '');
        var tableRow = $self.currentPressedBtn.parentElement.parentElement;
        $self.currentPressedBtn.removeEventListener('click', $self.clickEditButton);
        tableRow.innerHTML = content;
        $self.editAction();
      }

      //aaa

      this.editAction = function() {
        var collectionEditBtns = [].slice.apply(document.querySelectorAll('.edit-btn'));
        console.log(collectionEditBtns);
        
        collectionEditBtns.forEach(function (btn) {
          btn.addEventListener('click', $self.clickEditButton);
        });
      }
  
      this.clickEditButton = function() {

        event.preventDefault();

        var link = event.target.parentElement;
        var linkAjax = link.href;
  
        $.ajax({
          url: linkAjax,
          type: 'GET',
          success: function (data) {

            var html = $.parseHTML(data);

            $("#editStoreModalWrapper").replaceWith(html);

          }
        });

      
        $self.currentPressedBtn = this;  
        
        setTimeout(function() {$self.checkAllForms(currentPressedBtn);}, 500);
      }

    }
    // adding functionality to the eddit buttons
    // Todo: response of the action: handle the errors and also refactor the hardcoded holder

    
  }

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