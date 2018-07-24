var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window),
      currentPressedBtn;

    this.init = function () {
      // $self.removingEditFormFromModal();
      $self.addModelSelectInitialize();
      $self.removeImagePhotoFromDropArea();
      $self.travellingMaterialsState();
      $self.initializeSelect($('select'));
      $self.defaultMaterialSelect($('.default_material'));
      $self.checkAllForms();    
    };
    

    /* 
      FUNCTION THAT REMOVES THE "EDIT" FORM FROM THE MODALS WHEN IT'S CLOSED *THERE ARE SAME ISSUES CAUSED BECAUSE OF THE SAME IDs AND ETC.*
    */

    this.removingEditFormFromModal = function() {
      $('body').click(function() {
        if(!$('#editModel').hasClass('show')) {
          $('#editModel').find('form[name="edit"]').remove();
        }

        if(!$('#editProduct').hasClass('show')) {
         $('#editProduct').find('form[name="edit"]').remove(); 
        }
      });
    }

    /* 
      INITIALIZING SELECT2 IN THE ADD FORM , BECAUSE WHEN EDIT BUTTON IS CLICKED , THE SELECT2 IN ADDMODEL DESTROYS ITSELF.
    */

    this.addModelSelectInitialize = function() {
      var addModelButton = $('[data-target="#addModel"]');

      addModelButton.click(function() {
        $self.initializeSelect($('form[name="addModel"]').find('select'));   
      });
    }

    /* 
      FUNCTION THAT CONVERTS IMAGE URL TO BASE64 ENCODE 
    */

    // this.convertImageUrlToBase64 = function(url , callback) {
    //   var xhr = new XMLHttpRequest();
    //     xhr.onload = function() {
    //         var reader = new FileReader();
    //         reader.onloadend = function() {
    //             callback(reader.result);
    //         }
    //         reader.readAsDataURL(xhr.response);
    //     };
    //     xhr.open('GET', url);
    //     xhr.responseType = 'blob';
    //     xhr.send();
    // }
    
    // toDataUrl("http://127.0.0.1:8000/uploads/models/productimage_5b509c672ccd71532009575.png", function(myBase64) {
    //   console.log(myBase64); // myBase64 is the base64 string
    // });

    /*
      FUNCTION THAT RENDER THE IMAGES RECEIVED FROM THE AJAX CALL (E.G photos received from productsRequest ajax call)
    */

    this.uploadPhotosFromAjaxRequest = function(photoUrl) {
      var dropAreaGalleryHolder = $('.drop-area-gallery');
      var imageWrapper = $('<div class="image-wrapper"></div>');
      var newImg = $('<img>');

      newImg.attr('src' , 'data:image/png;base64,' + photoUrl);

      imageWrapper.append('<div class="close">x</div>');
      imageWrapper.append(newImg);
    
      dropAreaGalleryHolder.append(imageWrapper);
    }

    /*
      FUNCTION THAT REMOVES IMAGES FROM THE DROPAREA FROM BOTH ADDING PHOTOS ,AND FETCHING THEM FROM THE REQUEST.
    */

    this.removeImagePhotoFromDropArea = function() {
      $('form').on('click' , '.close' , function() {
        $(this).parent('.image-wrapper').remove();
      });
    }

    /* 
      FUNCTION THAT REPLACE THE TABLE ROW FROM THE AJAX REQUEST
    */

    this.replaceTableRowFromAjaxRequest = function(currentButton , rowId , response) {
      currentButton.parents("tr[data-id=" + rowId + "]").replaceWith(response);
    }

    /*
      FUNCTION THAT UPDATES THE STATUS OF TRAVELLING MATERIALS ( DECLINE OR ACCEPT )
    */

    this.travellingMaterialsState = function() {
      $('table').on('click' , '.material--travelling_state' , function(e) {
        e.preventDefault();
        
        var _this = $(this);
        var buttonState = _this.attr('data-travelstate');
        var buttonStateRowId = _this.parents('tr').attr('data-id');

        $.ajax({
          method: "POST",
          url: '/ajax/materials/' + buttonState + '/' + buttonStateRowId,
          success: function(resp) {
            var htmlResponse = JSON.stringify(resp.success);

            $self.replaceTableRowFromAjaxRequest(_this, buttonStateRowId , resp.success);
          }
        });
      });
    }

    /* 
      FUNCTION THAT GET THE SELECT OPTION'S ATTRIBUTES AND ATTACH THEM ON THE SELECT2 PLUGIN LIST ITEMS.
    */

    this.addSelect2CustomAttributes = function(data, container) {
      if(data.element) {
        $(container).attr({
          'data-price': $(data.element).attr('data-price') || 0,
          'data-pricebuy': $(data.element).attr('data-pricebuy') || 0,
          'data-retail': $(data.element).attr('data-retail') || 0,
          'data-material': $(data.element).attr('data-material') || 0
        });
      }

      return data.text;
    }

    /*
      FUNCTION THAT INITIALIZES THE SELECT 2 PLUGIN
    */

    this.initializeSelect = function (select) {
      select.select2({
        templateResult: $self.addSelect2CustomAttributes,
        templateSelection: $self.addSelect2CustomAttributes
      });
    }

    this.defaultMaterialSelect = function (defaultBtn) {
      var material = defaultBtn.closest('.form-row').find('.material_type');

      defaultBtn.off();
      defaultBtn.on('change', function() {
        if (defaultBtn.is(':checked')) {
          material.trigger('change');
        }
      })
    }

    this.addAndRemoveFieldsMaterials = function () {
      var collectionAddFieldBtn = document.querySelectorAll('.add_field_variation');

      collectionAddFieldBtn.forEach(function (btn) {
        var materialsWrapper = $(btn).closest('form').find('.model_materials');
        var defaultBtnsCollection = document.querySelectorAll('.default_material');

        $(btn).off();
        $(btn).on('click', function(e) {
          var materialsData = $('#materials_data').length > 0 ? JSON.parse($('#materials_data').html()) : null;
          var newRow = document.createElement('div');

          newRow.classList.add('form-row');

          var newFields = 
            '<div class="col-6">' +
            '<hr>' +
            '</div>' +
            '<div class="form-group col-md-12">' +
            '<label>Избери материал: </label>' +
            '<select id="material_type" name="material[]" class="material_type form-control calculate">' +
            '<option value="0">Избери</option>'

          materialsData.forEach(function (option) {
            newFields += `<option value=${option.value} data-pricebuy=${option.pricebuy} data-material=${option.material}>${option.label}</option>`;
          })

          newFields +=
            '</select>' +
            '</div>' +
            '<div class="form-group col-md-5">' +
            '<label>Цена на дребно: </label>' +
            '<select id="retail_prices" name="retail_price[]" class="form-control calculate prices-filled retail-price retail_prices" disabled>' +
            '<option value="0">Избери</option>' +
            '</select>' +
            '</div>' +
            '<div class="form-group col-md-5">' +
            '<label>Цена на едро: </label>' +
            '<select id="wholesale_price" name="wholesale_price[]" class="form-control prices-filled wholesale-price wholesale_price" disabled>' +
            '<option value="0">Избери</option>' +
            '</select>' +
            '</div>' +
            '<div class="form-group col-md-2">' +
            '<span class="delete-material remove_field"><i class="c-brown-500 ti-trash"></i></span>' +
            '</div>' +
            '<div class="form-group col-md-12">' +
            '<div class="radio radio-info">' +
            '<input type="radio" id="" class="default_material" name="default_material[]">' +
            '<label for="">Материал по подразбиране</label>' +
            '</div>' +
            '</div>';

          newRow.innerHTML = newFields;
          materialsWrapper[0].appendChild(newRow);

          defaultBtnsCollection = document.querySelectorAll('.default_material');
          for (i=0; i<defaultBtnsCollection.length; i++) {
            var defaultBtnId = 'material_' + String(i+1);

            defaultBtnsCollection[i].setAttribute('id', defaultBtnId);
            defaultBtnsCollection[i].nextElementSibling.setAttribute('for', defaultBtnId);
          }
          

          $self.initializeSelect($(newRow).find('select'));
          $self.defaultMaterialSelect($(newRow).find('.default_material'));
        });

        for (i=0; i<defaultBtnsCollection.length; i++) {
          var defaultBtnId = 'material_' + String(i+1);

          $self.defaultMaterialSelect($(defaultBtnsCollection[i]));
          defaultBtnsCollection[i].setAttribute('id', defaultBtnId);
          defaultBtnsCollection[i].nextElementSibling.setAttribute('for', defaultBtnId);
        }

        $(materialsWrapper).on('click', '.remove_field', function(event) {
          event.preventDefault();
          var parents = $(this).parentsUntil(".form-row .fields");
          parents[1].remove();
        });
      })
    }

    this.addAndRemoveFieldsStones = function () {
      var collectionAddFieldBtn = $('.add_field_button');

      collectionAddFieldBtn.each(function() {
        var thisBtn = $(this);
        var fieldsWrapper = $(this).parents().find('.model_stones');
        var stoneFlowBtnsCollection = document.querySelectorAll('.stone-flow');

        thisBtn.off();
        thisBtn.on('click', function(e) {
          var fields = fieldsWrapper.find('.fields');
          var stonesData = $('#stones_data').length > 0 ? JSON.parse($('#stones_data').html()) : null;
          var maxFields = 10;
                    
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
              '<div class="form-group col-md-4">' +
              '<label>Брой:</label>' +
              '<input type="text" class="form-control calculate-stones" name="stone_amount[]" placeholder="Брой">' +
              '</div>' +
              '<div class="form-group col-md-2">' +
              '<span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>'+
              '</div>' +
              '<div class="form-group col-md-6">' +
              '<div class="form-group">' +
              '<label>Тегло: </label>' +
              '<input type="number" class="form-control calculate-stones" name="stone_weight[]" placeholder="Тегло:" min="0.1" max="100">' +
              '</div>' +
              '</div>' +
              '<div class="form-group col-md-6">' +
              '<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">' +
              '<input type="checkbox" id="" class="stone-flow calculate-stones" name="stone_flow[]" class="peer">' +
              '<label for="" class="peers peer-greed js-sb ai-c">' +
              '<span class="peer peer-greed">За леене</span>' +
              '</label>' +
              '<span class="row-total-weight"></span>' +
              '</div>' +
              '</div>';

            fieldsHolder.innerHTML = newFields;
            fieldsWrapper.append(fieldsHolder);

            stoneFlowBtnsCollection = document.querySelectorAll('.stone-flow');
            for (i=0; i<stoneFlowBtnsCollection.length; i++) {
              var stoneFlowBtnId = 'stoneFlow_' + String(i+1);

              stoneFlowBtnsCollection[i].setAttribute('id', stoneFlowBtnId);
              stoneFlowBtnsCollection[i].nextElementSibling.setAttribute('for', stoneFlowBtnId);
            }

            $self.initializeSelect(fieldsWrapper.find('select'));
          }
        });

        for (i=0; i<stoneFlowBtnsCollection.length; i++) {
          var stoneFlowBtnId = 'stoneFlow_' + String(i+1);

          stoneFlowBtnsCollection[i].setAttribute('id', stoneFlowBtnId);
          stoneFlowBtnsCollection[i].nextElementSibling.setAttribute('for', stoneFlowBtnId);
        }

        $(fieldsWrapper).on('click', '.remove_field', function(event) {
          event.preventDefault();
          var parents = $(this).closest(".form-row");
          $self.calculateStones(parents[0], false);
          parents.remove();
        });
      });
    }

    this.calculateStones = function(row, add) {
      var amount = row.querySelector('input[name="stone_amount[]"]').value;
      var weight = row.querySelector('input[name="stone_weight[]"]').value;
      var rowTotalNode = row.querySelector('.row-total-weight');
      var total;
      var totalNode = row.parentNode.parentNode.querySelector('#totalStones');
      var currentTotal = 0;
      var newTotal;
      var siblingsArray = Array.prototype.filter.call(row.parentNode.children, function(child){
        return child !== row;
      });

      total = amount * weight;

      siblingsArray.forEach(function(el) {
        var a = el.querySelector('input[name="stone_amount[]"]').value;
        var w = el.querySelector('input[name="stone_weight[]"]').value;

        if (el.querySelector('.stone-flow').checked) {
          currentTotal += a*w
        }
      })

      if (add) {
        newTotal = currentTotal*1 + total;
        rowTotalNode.innerHTML = `(${total} гр.)`;
        rowTotalNode.style.opacity = 1;
      }
      else {
        newTotal = currentTotal;
        rowTotalNode.style.opacity = 0;
        rowTotalNode.parentNode.querySelector('input[type="checkbox"]').setAttribute('disabled', true);
        setTimeout(function() {
          rowTotalNode.innerHTML = '';
          rowTotalNode.parentNode.querySelector('input[type="checkbox"]').removeAttribute('disabled');
        }, 400);
      }

      totalNode.value = newTotal;
    }
    
    this.dropFunctionality = function(instanceFiles) {
      var dropArea = $('.drop-area'),
          preventEvents = ['dragenter', 'dragover', 'dragleave', 'drop'],
          highlightEvents = ['dragenter', 'dragover'],
          unhighlightEvents = ['dragleave', 'drop'];

      dropArea.each(function() {
        var thisArea = $(this),
            dropAreaInput = thisArea.find('.drop-area-input'),
            dropAreaGallery = thisArea.find('.drop-area-gallery');

        dropAreaInput.off();
        dropAreaInput.on('change', function(ev) {

          var files = ev.target.files,
              collectionFiles= [];
         
          for(var file of files) {
            collectionFiles.push(file);
          }

          handleFiles(collectionFiles);
        
        });

        preventEvents.forEach(function(eventName) {
          thisArea[0].addEventListener(eventName, preventDefaults, false);
        }); 
        
        highlightEvents.forEach(function(eventName) {
          thisArea[0].addEventListener(eventName, highlight, false);
        });
  
        unhighlightEvents.forEach(function(eventName) {
          thisArea[0].addEventListener(eventName, unhighlight, false);
        });
        
        thisArea[0].addEventListener('drop', handleDrop, false);

        function highlight(e) {
          thisArea.addClass('highlight');
        }
        
        function unhighlight(e) {
          thisArea.removeClass('highlight');
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
            var imageWrapper = document.createElement('div');
            var closeBtn = document.createElement('div');
            var img = document.createElement('img');

            toDataURL(
              reader.result,
              function(dataUrl) {
                var data = dataUrl.replace('data:image/png;base64,',''); 
                instanceFiles.push(data);          
              }
            )   

            imageWrapper.setAttribute("class", "image-wrapper");
            closeBtn.setAttribute("class", "close");
            closeBtn.innerHTML = '&#215;';            
            
            img.src = reader.result;
            imageWrapper.append(closeBtn);
            imageWrapper.append(img);
            dropAreaGallery.append(imageWrapper);
          }
        }  
      });

      var imageDeleteBtn = $('.image-wrapper .close');
      
      imageDeleteBtn.each(function() {
        var imageDeleteBtn = $(this);

        imageDeleteBtn.off();
        imageDeleteBtn.on('click', deleteUploadedImage);
      });

      function deleteUploadedImage(e) {
        var deleteUrl = $(this).find('span').attr('data-url');
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';

        if((deleteUrl !== undefined) && (deleteUrl.length > 0)){
          var ajaxUrl = url + '/' + deleteUrl;

          $.ajax({
            url: ajaxUrl,
            method: "POST",
            success: deleteUploadedImageSuccess(e)
          });
        }
      }

      function deleteUploadedImageSuccess(e) {
        $(e.target).parents('.image-wrapper').remove();
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
      var collectionModalAddBtns = document.querySelectorAll('.modal-dialog .modal-footer .add-btn-modal');
      var collectionScanRepairBtns = document.querySelectorAll('.scan-repair');
      var collectionReturnRepairBtns = document.querySelectorAll('.return-repair');
      var collectionReturnRepairActionBtns = document.querySelectorAll('.return-repair-action');
      var printBtns = document.querySelectorAll('.print-btn');
      var deleteBtns = document.querySelectorAll('.delete-btn');
      var paymentBtns = document.querySelectorAll('.payment-btn');
      var certificateBtns = document.querySelectorAll('.certificate');
      var paymentModalSubmitBtns = document.querySelectorAll('.btn-finish-payment');
      var urlTaken = window.location.href.split('/');
      var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
      var token = $('meta[name="csrf-token"]').attr('content');
      var form;
      var nameForm;
      var numberItemInput = document.getElementById("product_barcode");
      var barcodeProcessRepairInput = document.getElementById("barcode_process-repairs");
      var barcodeReturnRepairInput = document.getElementById("barcode_return-repairs");
      var catalogNumberInput = document.getElementById("catalog_number");
      var amountInput =  document.getElementById("amount");
      var typeRepairInput = document.getElementById("type_repair");
      var moreProductsInput = document.getElementById("amount_check");
      var discountInput = document.getElementById("add_discount");
      var discountCardInput = document.getElementById("discount_card");
      var paymentModalCashRadio = document.getElementById('pay-method-cash');
      var paymentModalPosRadio = document.getElementById('pay-method-pos');
      var paymentModalPriceInput = document.getElementById('wanted-sum');
      var paymentModalGivenInput = document.getElementById('given-sum');
      var paymentModalReturnInput = document.getElementById('return-sum');
      var paymentModalCurrencySelector = document.getElementById('pay-currency');
      var sellingForm = document.getElementById('selling-form');
      var returnRepairForm = document.getElementById('return-repair-form');
      var returnScanForm = document.getElementById('scan-repair-form');
      var collectionModelPrice = [].slice.apply(document.querySelectorAll('.calculate'));
      var collectionFillFields = [].slice.apply(document.querySelectorAll('.fill-field'));
      var pendingRequest = false;

      editAction();

      function calculatePrice(jeweryPrice, dataWeight , priceDev , currentElement) {
        var typeJeweryData = jeweryPrice;
        var weightData = dataWeight;
        var priceData = priceDev;
        var element = currentElement;        
        var inputDev = element.children().find('.worksmanship_price'),
          inputPrice = element.children().find('.final_price');

        if (typeJeweryData && priceData && weightData) {
          var priceDev = (priceData - typeJeweryData) * weightData;
          var productPrice = (priceData * weightData);

          inputDev.val(priceDev);
          inputPrice.val(productPrice);
        } else {
          inputDev.val('0');
          inputPrice.val('0');
        }
      }

      var jeweryPrice = 0;
      var dataWeight = 0;
      var priceDev = 0;

      $("form").on('change' , '.calculate' , function(e) {
        var _element = $(e.currentTarget);
        var ajaxUrl = window.location.origin + '/ajax/getPrices/';
        var parentElement = _element.parents('form');

        if(_element[0].nodeName == 'SELECT') {

          if(_element[0].classList.contains('material_type')) {
            var materialType = _element.find(':selected').val();
            var materialAttribute = _element.find(':selected').attr('data-material');
            var pricesFilled = _element.closest('.form-row').children().find('.prices-filled');
            var retaiPriceFilled = _element.closest('.form-row').find('.retail-price');
            var wholesalePriceFilled = _element.closest('.form-row').find('.wholesale-price');
            var requestLink = ajaxUrl + materialAttribute;

            if(materialType == 0) {
              pricesFilled.val('0');
              pricesFilled.trigger('change');
              pricesFilled.attr('disabled', true);
              return;
            }
            
            jeweryPrice = _element.find(':selected').attr('data-pricebuy');

            if (_element.closest('#addProduct').length > 0 || _element.closest('#editProduct').length > 0) {
              var modelId = _element.closest('form').find('.model-select option:selected').val();
              requestLink += '/' + modelId;
            }
            else {
              requestLink += '/0';
            }

            if (materialAttribute !== undefined) {
              ajaxFn('GET' , requestLink , function(response) {

                var retailData = response.retail_prices;
                var wholesaleData = response.wholesale_prices;
                var models = response.pass_models;
                var modelsData = models.map(function(keys) {
                  return {
                    id: keys.id,
                    text: keys.name,
                    jewel: keys.jewel,
                    retail_price: keys.retail_price,
                    wholesale_price: keys.wholesale_price,
                    weight: keys.weight,
                    workmanship: keys.workmanship
                  }
                });

                //_element.parents('form').children().find('.model-filled').empty();
                _element.parents('form').children().find('.model-filled').select2({
                  data: modelsData,
                  templateResult: $self.addSelect2CustomAttributes,
                  templateSelection: $self.addSelect2CustomAttributes
                }); 
          
                var newRetailData = retailData.map(function(keys) {
                  return {
                    id: keys.id,
                    text: keys.slug + ' - ' + keys.price,
                    price: keys.price,
                    material: keys.material
                  }
                });

                var newWholesaleData = wholesaleData.map(function(keys) {
                  return {
                    id: keys.id,
                    text: keys.slug + ' - ' + keys.price,
                    price: keys.price,
                    material: keys.material
                  }
                });

                pricesFilled.empty();

                for (i=0; i<pricesFilled.length; i++) {
                  var chooseOpt = document.createElement('option');
                  chooseOpt.innerHTML = 'Избери';
                  chooseOpt.setAttribute('value', '0');

                  if (i > 0) {
                    var chooseArray = [];

                    chooseArray[i] = chooseOpt.cloneNode(true);
                    pricesFilled[i].appendChild(chooseArray[i]);
                  }
                  else {
                    pricesFilled[i].appendChild(chooseOpt);
                  }
                }

                retaiPriceFilled.select2({
                  data: newRetailData,
                  templateResult: $self.addSelect2CustomAttributes,
                  templateSelection: $self.addSelect2CustomAttributes
                });

                wholesalePriceFilled.select2({
                  data: newWholesaleData,
                  templateResult: $self.addSelect2CustomAttributes,
                  templateSelection: $self.addSelect2CustomAttributes
                });     

                for (i=0; i<pricesFilled.length; i++) {
                  var select = $(pricesFilled[i]).find('option:nth-of-type(2)');
                  var selectValue = select.val();

                   $(pricesFilled[i]).val(selectValue);
                }

                //$('#retail_prices').trigger('change');
                //$('#retail_price_edit').trigger('change');
                pricesFilled.trigger('change');
                pricesFilled.attr('disabled', false);
              });
            }
          }
          else {
            if( _element.select2('data')[0] !== undefined && (_element.closest('.form-row').find('[name="default_material[]"]:checked').length > 0 || _element.closest('#addProduct').length > 0 || _element.closest('#editProduct').length > 0)){
              priceDev = _element.select2('data')[0].price;
            }
          }

          if(_element[0].classList.contains('material_type')) {
            dataWeight = _element.closest('form').find('.weight-holder').children('input').val();
          } else if (_element[0].id == 'jewel_edit') {
            dataWeight = _element.closest('form').find('.weight-holder-edit').children('input').val();
          }

          if (_element.closest('.form-row').find('[name="default_material[]"]:checked').length > 0  || _element.closest('#addProduct').length > 0 || _element.closest('#editProduct').length > 0) {
            calculatePrice(jeweryPrice , dataWeight , priceDev , parentElement);
          }
          
        }
        else {
          dataWeight = _element[0].value;
          calculatePrice(jeweryPrice , dataWeight , priceDev , parentElement);
        }
      });

      $("form").on('change', '.calculate-stones', function(e) {
        var _element = $(e.currentTarget);
        var row = _element.closest('.form-row');
        var add = true;

        if (_element[0].classList.contains('stone-flow')) {
          add = _element[0].checked;
          $self.calculateStones(row[0], add);
        }
        else if (row[0].querySelector('.stone-flow').checked) {
          $self.calculateStones(row[0], add);
        }
      })

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

      var collectionModalEditBtns = document.querySelectorAll('.modal-dialog .modal-footer .edit-btn-modal');

      if(collectionModalEditBtns.length > 0) {
        var modelSelectEdit = $('#model_select_edit');
        var typeSelect;
        var collectionFiles = [];
        var dropZone = document.getElementsByClassName("drop-area");
        
        if(dropZone) {
            this.dropFunctionality(collectionFiles);   
        }

        if(modelSelectEdit) {
          modelSelectEdit.off();
          modelSelectEdit.on('change select2:select', function(ev) {
            var targetModal = document.getElementById('editProduct');
            if(modelSelectEdit.val()) {
              var value = modelSelectEdit.find(':selected').val(),
                  tempUrl = url + '/products/' + value,
                  xhttp = new XMLHttpRequest(),
                  typeSelect = $('#material_type');

              typeSelect.on('select2:select', function(ev) {
                modelSelectEdit.val('0').trigger('change.select2');
              });

              productsRequest(tempUrl, targetModal);
            }
          });
        }
          
        collectionModalEditBtns.forEach(function (btn) {
          btn.removeEventListener('click', getFormData, true);
          btn.addEventListener('click', getFormData);
        })
      }
     
      if(collectionModalAddBtns.length > 0) {
        var modelSelect = $('#model_select');
        var typeSelect;
        var collectionFiles = [];
        var dropZone = document.getElementsByClassName("drop-area");

        if(dropZone) {
          this.dropFunctionality(collectionFiles);         
        }

        if(modelSelect) {
          modelSelect.off();
          modelSelect.on('select2:select', function(ev) {

            var targetModal = document.getElementById('addProduct');
            if(modelSelect.val()) {

              /* CLEARING THE GALLERY CONTAINER ON CHANGE */
              $(this).parents('form').find('.drop-area-gallery').empty();

              var value = modelSelect.find(':selected').val(),
                  tempUrl = url + '/products/' + value,
                  xhttp = new XMLHttpRequest(),
                  typeSelect = $('#material_type');

              typeSelect.on('select2:select', function(ev) {
                modelSelect.val('0').trigger('change.select2');
              });

              $('.prices-filled').attr('disabled', false);

              productsRequest(tempUrl, targetModal);
            }
          });
        }
          
        collectionModalAddBtns.forEach(function (btn) {
          $(btn).off();
          $(btn).on('click', getFormData); 
        });
      }

      if(collectionScanRepairBtns.length > 0) {
        collectionScanRepairBtns.forEach(function (btn) {
          btn.addEventListener('click', function() {
            var returnRepairWrapper = document.getElementById('scan-repair-wrapper');
            var nextElement = returnRepairWrapper.nextElementSibling;

            if(nextElement != null){
              nextElement.parentNode.removeChild(nextElement);
            }

            returnRepairWrapper.style.display = 'block';
            returnRepairWrapper.querySelector('.info-cont').innerHTML='';
            document.getElementById('barcode_process-repairs').value = '';
          });
        });
      }

      if(collectionReturnRepairBtns.length > 0) {
        collectionReturnRepairBtns.forEach(function (btn) {
          btn.addEventListener('click', function() {
            var returnRepairWrapper = document.getElementById('return-repair-wrapper');
            var nextElement = returnRepairWrapper.nextElementSibling;

            if(nextElement != null){
              nextElement.parentNode.removeChild(nextElement);
            }

            returnRepairWrapper.style.display = 'block';
            returnRepairWrapper.querySelector('.info-cont').innerHTML='';
            document.getElementById('barcode_return-repairs').value = '';
          });
        });
      }

      if(collectionReturnRepairActionBtns.length > 0) {
        collectionReturnRepairActionBtns.forEach(function (btn) {
          btn.addEventListener('click', function() {
            var url = this.getAttribute('data-url');
            var ajaxUrl = window.location.origin + '/ajax/' + url;
            ajaxFn("GET", ajaxUrl, sendReturnRepairBarcodeSuccess, '', '', '');
          });
        });
      }

      if(catalogNumberInput !== null) {
        catalogNumberInput.addEventListener('change', addCatalogNumber);
      }

      function addCatalogNumber() {
        var catalogNumber = this.value;
        var amountValue = amountInput.value;
        var amountCheck = moreProductsInput.checked;
        var ajaxUrl = sellingForm.getAttribute("data-scan");
        var dataSend = {
          'catalog_number' : catalogNumber,
          'quantity' : Number(amountValue),
          'amount_check' : amountCheck
        };

        ajaxFn('POST', ajaxUrl, sendSuccess, dataSend, '', '');
        catalogNumberInput.value = "";
      }

      if(discountInput !== null){
        discountInput.addEventListener('click', addDiscount);
      }

      if(discountCardInput !== null){
        discountCardInput.addEventListener('change',addCardDiscount);
      }

      function addCardDiscount() {
        var discountCardBarcode = this.value;
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax/';
        var discountUrl = discountInput.getAttribute("data-url");

        if(discountCardBarcode.length == 13) {
          var ajaxUrl = url + discountUrl + '/'+ discountCardBarcode;

          ajaxFn("GET", ajaxUrl, discountSuccess, '', '', '');
          discountCardInput.value="";
        }
      }

      function addDiscount() {
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax/';
        var discountUrl = this.getAttribute("data-url");
        var discountSelect = document.getElementById("discount");
        var barcode = discountSelect.options[discountSelect.selectedIndex].value;

        if(barcode.length > 0) {
          var ajaxUrl = url + discountUrl + '/' + barcode;

          ajaxFn("GET", ajaxUrl, discountSuccess, '', '', '');
        }
      }


      function discountSuccess(data) {
        var success = data.success;
        var subTotalInput = document.getElementById("subTotal");
        var totalInput = document.getElementById("total");

        if(success) {
          subTotalInput.value = data.subtotal;
          totalInput.value = data.total;
        }
      }

      if(moreProductsInput!==null){
        moreProductsInput.addEventListener('click', moreProductsSelected);

        function moreProductsSelected(){
          if(this.checked ) {
            amountInput.readOnly = false;
          } 
          else {
            amountInput.readOnly = true;
          }
        };
      }

      function formPreventDefault(form) {
        form.addEventListener('submit', function(event) { event.preventDefault(); });
      }
      
      if(sellingForm !== null) {
        formPreventDefault(sellingForm);
      }  

      if(returnRepairForm !== null) {
        formPreventDefault(returnRepairForm);
      }  

      if(returnScanForm !== null) {
        formPreventDefault(returnScanForm);
      }  

      if(numberItemInput !== null) {
        numberItemInput.addEventListener('change', sendItem);
      }

      function sendItem(event) {
         var numberItemValue = this.value;
         var amountValue = amountInput.value;
         var amountCheck = moreProductsInput.checked;
         var typeRepair = typeRepairInput.checked;

         if(numberItemValue.length == 13){
          var dataSend = {
            'barcode' : Number(numberItemValue),
            'quantity' : Number(amountValue),
            'amount_check' : amountCheck,
            'type_repair' : typeRepair
          };
           var currentElement = $(event.target);
           var form = currentElement.closest("form");
           var ajaxUrl = form.attr("data-scan");

           ajaxFn("POST", ajaxUrl, sendSuccess, dataSend, '', '');
         }
      }

      function sendSuccess(data, elements, btn) {
        var success = data.success;
        var subTotalInput = document.getElementById("subTotal");
        var totalInput = document.getElementById("total");
        var barcodeInput = document.getElementById("product_barcode");
        var html = data.table;
        var shoppingTable = document.getElementById("shopping-table");
        var nodes = shoppingTable.childNodes;
        var tbody = nodes[3];

        if(success) {
          tbody.innerHTML = html;
          subTotalInput.value = data.subtotal;
          totalInput.value = data.total;
          barcodeInput.value = "";
        }
      }

      if(barcodeProcessRepairInput !== null) {
        barcodeProcessRepairInput.addEventListener('change',sendProcessRepairBarcode);
      }

      function sendProcessRepairBarcode(event) {
        var processRepairBarcodeInput = event.target;
        var processRepairBarcode = processRepairBarcodeInput.value;

        if(processRepairBarcode.length > 0) {
          var urlTaken = window.location.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs/edit';
          var ajaxUrl = url + '/' + processRepairBarcode;

          ajaxFn("GET",ajaxUrl,sendProcessRepairBarcodeSuccess,'','',processRepairBarcodeInput);
        } 
      }

      function sendProcessRepairBarcodeSuccess(data, elements, btn) {
        var modalContent = btn.parentElement.closest('.modal-content');
        var editWrapper = document.createElement('DIV');

        editWrapper.innerHTML = data; 
        modalContent.children[0].style.display = 'none';
           
        if(modalContent.children.length > 1){
          modalContent.children[1].remove();
        }

        modalContent.appendChild(editWrapper);
        $self.checkAllForms();
        pendingRequest = true;
      }

      if(barcodeReturnRepairInput !== null) {
        barcodeReturnRepairInput.addEventListener('change',sendReturnRepairBarcode);
      }

      function sendReturnRepairBarcode(event) {
        var processReturnBarcodeInput = event.target;
        var processReturnBarcode = processReturnBarcodeInput.value;

        if(processReturnBarcode.length > 0) {
          var urlTaken = window.location.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs/return';
          var ajaxUrl = url + '/' + processReturnBarcode;

          ajaxFn("GET", ajaxUrl, sendReturnRepairBarcodeSuccess, '', '', processReturnBarcodeInput);
        } 
      }

      
      function sendReturnRepairBarcodeSuccess(data, elements, btn) {
        if(data.hasOwnProperty('success')){
          window.location.replace(data.redirect);
        }
        else if(data.hasOwnProperty('errors')) {
          var alertAreas = [].slice.apply(document.getElementsByClassName('info-cont'));

          alertAreas.forEach(function(responseHolder) {
            var holder = document.createDocumentFragment();
            var errors = data.errors;
            responseHolder.innerHTML = "";

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
          });
        }
      }

      printBtns.forEach(function(btn){
        $(btn).off('click',print);
        $(btn).on('click',print);
      });

      deleteBtns.forEach(function(btn){
        btn.addEventListener('click',deleteRowRecord);
      });

      certificateBtns.forEach(function(btn){
        btn.addEventListener('click',printCertificate);
      });
  
      function print(event) {
        if(event.currentTarget && event.currentTarget.classList.contains('print-btn')) {
          event.preventDefault();
          event.stopPropagation();

          var urlTaken = event.currentTarget.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
          var link = event.currentTarget;
          var linkPath = link.href.split("admin")[1];

          if (typeof linkPath == 'undefined') {
            linkPath = '/sellings/information';
          }

          var ajaxUrl = url+linkPath;
    
          ajaxFn("GET",ajaxUrl,printBtnSuccess,'','',link);
        }
      }

      function printBtnSuccess(data) {
        if(data.success){
          var toPrint = data.html;
          var node = document.createElement("div");
          var printElement = document.body.appendChild(node);

          printElement.classList.add("to-print");
          printElement.innerHTML = toPrint;
          document.body.classList.add("print-mode");
          window.print();
          document.body.removeChild(node);
          document.body.classList.remove("print-mode")
        }
      }

      paymentBtns.forEach(function(btn) {
        btn.addEventListener('click', paymentBtnClick);
      })

      if (paymentModalPosRadio !== null){
        paymentModalPosRadio.addEventListener('change', paymentPosClicked);
      }

      if (paymentModalCashRadio !== null){
        paymentModalCashRadio.addEventListener('change', paymentCashClicked);
      }

      if (paymentModalGivenInput !== null){
        paymentModalGivenInput.addEventListener('keyup', calculateReturn);
      }

      if (paymentModalCurrencySelector !== null){
        $(paymentModalCurrencySelector).on('select2:select', currencySelect);
      }

      paymentModalSubmitBtns.forEach(function(btn) {
        btn.addEventListener('click', getFormData);
      })

      if (document.querySelector('option[data-default="yes"]')) {
        var defaultCurrencyVal = document.querySelector('option[data-default="yes"]').value;
      }

      function paymentBtnClick(event) {
        if (event.target.classList.contains('payment-btn')) {
          var price = document.getElementById('total').value;

          paymentModalPriceInput.value = price;
          $(paymentModalCurrencySelector).val(defaultCurrencyVal);  // set the currency select2 to BGN
          $(paymentModalCurrencySelector).trigger('change');
        }
      }

      function paymentPosClicked(event) {
        var disable = document.createAttribute('readonly');
        var price = document.getElementById('total').value;

        paymentModalGivenInput.setAttributeNode(disable);
        paymentModalCurrencySelector.setAttribute('disabled', true);
        $(paymentModalCurrencySelector).val(defaultCurrencyVal);  // set the currency select2 to BGN
        $(paymentModalCurrencySelector).trigger('change');
        $(paymentModalCurrencySelector).trigger('select2:select');
        paymentModalCurrencySelector.getElementsByTagName('option')[0].selected = 'selected';
        paymentModalGivenInput.value = price;
        paymentModalReturnInput.value = 0;
      }

      function paymentCashClicked(event) {
        paymentModalGivenInput.removeAttribute('readonly');
        paymentModalCurrencySelector.removeAttribute('disabled');
        paymentModalGivenInput.value = '';
        paymentModalReturnInput.value = '';
      }

      function calculateReturn(event) {
        var price = paymentModalPriceInput.value;
        var given = paymentModalGivenInput.value;
        var returnSum = Math.round((given - price) * 100) / 100;

        paymentModalReturnInput.value = returnSum;
      }

      function currencySelect(event) {
        var currentPrice = document.getElementById('total').value;
        var currencyValue = $(event.target).find('option:selected')[0].getAttribute('data-currency');
        var newPrice = currentPrice * currencyValue;
        
        paymentModalPriceInput.value = newPrice;
        if (paymentModalGivenInput.value != '') {
          calculateReturn();
        }
      }


      function deleteRowRecord(event) {    
        if(event.currentTarget && event.currentTarget.classList.contains('delete-btn')) {
          event.preventDefault();
          event.stopPropagation();
          
          if (confirm("Сигурен ли си, че искаш да изтриеш записа?")) {
            var url = window.location.origin + '/ajax';
            var link = event.currentTarget;
            var linkPath = link.getAttribute('data-url');
            var ajaxUrl = url + '/'+ linkPath;

            ajaxFn("POST", ajaxUrl, deleteBtnSuccess, '', '', link);
          }       
        }
      }

      function createErrorMessage(table, text) {
         var messageWrapper = document.createElement('div');

         messageWrapper.className  = 'alert alert-danger';
         messageWrapper.innerText = text;
         table.before(messageWrapper);
         setTimeout(function(){ messageWrapper.remove(); }, 3000);
      }

      function deleteBtnSuccess(data, elements, btn) {     
        if(data.hasOwnProperty('errors')){
          var table = document.querySelector('table');
          var text = data.errors.using;
          createErrorMessage(table,text);         
        }
        else {
          var td = btn.parentElement;
          var tr = td.parentElement;
          var table = tr.parentElement;

          table.removeChild(tr);  

          if($(btn).hasClass("cart")){
            var success = data.success;
            var subTotalInput = document.getElementById("subTotal");
            var totalInput = document.getElementById("total");

            if(success) {
              subTotalInput.value = data.subtotal;
              totalInput.value = data.total;
            }
          }
        }
      }

      function printCertificate(e) {
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs';
        var certificateId = e.target.getAttribute('data-repair-id');
        var ajaxUrl = url + '/certificate/' + certificateId;

        ajaxFn("GET",ajaxUrl,printBtnSuccess,'','','');
      } 

      function getFormData(event) {
        var evt = event || window.event;

        evt.preventDefault();

        if(pendingRequest) return;
        pendingRequest = true;

        form = evt.target.parentElement.parentElement;
        nameForm = form.getAttribute('name');

        var urlAction = form.getAttribute('action'),
          formMethod = 'POST',
          ajaxUrl = url + urlAction;
          collectionInputs = [].slice.apply(form.getElementsByTagName('input'));
          collectionTextareas = [].slice.apply(document.forms[nameForm].getElementsByTagName('textarea'));              
          collectionSelects = [].slice.apply(form.getElementsByTagName('select'));
          collectionElements = [];
      
          var collectionData = {_token: token};   

              if (collectionInputs.length != 0) {
                collectionInputs.map(function (el) {
                  if (el != 'undefined') {
                    var name = el.getAttribute('name');
                    var elType = el.getAttribute('type'); 
                    var value = elType === 'checkbox' ? el.checked : el.value;

                    if (name === 'images') {
                      var images = [];
                      var uploadedImages = $(el).parent().find('.drop-area-gallery').children();

                      for (var i=0; i<uploadedImages.length; i++){
                        var image = $(uploadedImages[i]).find('img');
                        var imageSrc = $(image).attr('src');
                        var imagePath = imageSrc.split(',')[1];

                        images.push(imagePath);
                      }

                      collectionData[name] = images;
                      collectionElements.push(el);
                      return true;
                    } 

                    else if (name.includes('[]')) {
                      name = name.replace('[]', '');

                      if (elType === 'radio') {
                        value = el.checked;
                      }

                      if (collectionData.hasOwnProperty(name)) {
                        collectionData[name].push(value);

                      } 
                      else {
                        collectionData[name] = [value];
                      }

                      collectionElements.push(el);
                    } 
                    else if (elType === 'radio' && el.checked) {
                      collectionData[name] = value;
                      collectionElements.push(el);
                    }
                    else if (elType === 'radio' && !el.checked) {
                      return;
                    }
                    else {
                      if (name === '_method') {
                        formMethod = value;
                      }
                      
                      collectionData[name] = value;
                      collectionElements.push(el);
                    }
                  }
                });
              }

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

                      collectionElements.push(collectionSelects[i]);

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

      function productsRequest(tempUrl, targetModal) {
        var xhttp = new XMLHttpRequest();

        xhttp.open('GET', tempUrl, true);
        xhttp.onreadystatechange = function () {

        if(this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          var editHolder =  document.getElementById("jewel_edit");

          var responsePhotos = data.photos;

          for (i=0; i<data.materials.length; i++) {
            var material = data.materials[i];

            if (material.selected) {
              var selectedMaterial = material.value;
            }
          }

          for(var key in data) {
            var holder = targetModal.querySelector(`.${key}`);

            if(holder) {
              var tagName = holder.tagName.toLowerCase();
              
              switch(tagName) {
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
                    option.setAttribute('data-pricebuy' , el.pricebuy || 0);

                    if(el.price) {
                      option.setAttribute('data-price' , el.price || 0);
                    }
                      
                    if(el.hasOwnProperty('selected') && el['selected']) {
                      option.selected = true;
                    }
                     
                    holder.add(option);
                      if(editHolder!==null){
                        editHolder.add(option);
                      }
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
              else if (key == 'stones') {
                var stonesArray = data[key];
                var fieldsWrapper = targetModal.querySelector('.model_stones');
                var stonesData = $('#stones_data').length > 0 ? JSON.parse($('#stones_data').html()) : null;

                fieldsWrapper.innerHTML = '';

                for (i=0; i<stonesArray.length; i++) {
                  var current = stonesArray[i];

                  var stoneValue = current['value'];
                  var amount = current.amount;
                  var weight = current.weight;
                  var flow = current.flow == 'yes' ? 'checked' : '';

                  var stoneRow = document.createElement('div');
                  stoneRow.classList.add('form-row', 'fields');

                  var newFields =
                    '<div class="form-group col-md-6">' +
                    '<label>Камък:</label>' +
                    '<select name="stones[]" class="form-control">';

                  stonesData.forEach(function (option) {
                    var selected = stoneValue == option.value ? 'selected' : '';
                    newFields += `<option value=${option.value} ${selected}>${option.label}</option>`
                  });

                  newFields +=
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label>Брой:</label>' +
                    `<input type="text" value=${amount} class="form-control calculate-stones" name="stone_amount[]" placeholder="Брой">` +
                    '</div>' +
                    '<div class="form-group col-md-2">' +
                    '<span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>'+
                    '</div>' +
                    '<div class="form-group col-md-6">' +
                    '<div class="form-group">' +
                    '<label>Тегло: </label>' +
                    `<input type="number" value=${weight} class="form-control calculate-stones" name="stone_weight[]" placeholder="Тегло:" min="0.1" max="100">` +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group col-md-6">' +
                    '<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">' +
                    `<input type="checkbox" id="" class="stone-flow calculate-stones" name="stone_flow[]" class="peer" ${flow}>` +
                    '<label for="" class="peers peer-greed js-sb ai-c">' +
                    '<span class="peer peer-greed">За леене</span>' +
                    '</label>' +
                    '<span class="row-total-weight"></span>' +
                    '</div>' +
                    '</div>';

                  stoneRow.innerHTML = newFields;
                  fieldsWrapper.appendChild(stoneRow);

                  var event = document.createEvent('HTMLEvents');
                  var el = stoneRow.querySelector('input.stone-flow:checked')
                  event.initEvent('change', true, false);

                  if (el) {
                    el.dispatchEvent(event);
                  }
                }

                var stoneFlowBtnsCollection = document.querySelectorAll('.stone-flow');

                for (i=0; i<stoneFlowBtnsCollection.length; i++) {
                  var stoneFlowBtnId = 'stoneFlow_' + String(i+1);

                  stoneFlowBtnsCollection[i].setAttribute('id', stoneFlowBtnId);
                  stoneFlowBtnsCollection[i].nextElementSibling.setAttribute('for', stoneFlowBtnId);
                }

                $self.initializeSelect($(fieldsWrapper).find('select'));
              }
            }

          
          responsePhotos.map(function(element) {
            var photoUrl = element.base64;
            $self.uploadPhotosFromAjaxRequest(photoUrl);
          });

            var materialSelect = $(targetModal).find('.material_type');
            materialSelect.val(selectedMaterial);
            materialSelect.trigger('change');
            materialSelect.trigger('select2:select');
          }
        };

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xhttp.send();
      }

      function fillValue(el, value) {
          if(typeof(value) == 'undefined') {
            value = '';
          }
          
          document.querySelector(el).value = value;
      }

      function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
      }

      function ajaxFn(method, url, callback, dataSend, elements, currentPressedBtn) {
        var xhttp = new XMLHttpRequest();

        xhttp.open(method, url, true);

        xhttp.onreadystatechange = function () {
          if(this.readyState == 4 && this.status == 200) {
            if(IsJsonString(this.responseText)){
              var data = JSON.parse(this.responseText);
            }
             else {
               var data = this.responseText;
            }
            
            callback(data, elements, currentPressedBtn);
          } else if (this.readyState == 4 && this.status == 401) {
            var data = JSON.parse(this.responseText);
            callback(data);
          }
        };

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        
        if(method === "GET") {
          xhttp.send();
        }
        else {
          xhttp.send(JSON.stringify(dataSend));
        }
      }
     
      function handleResponsePost(response, elements, currentPressedBtn) {
        var alertAreas = [].slice.apply(document.getElementsByClassName('info-cont'));

        alertAreas.forEach(function(responseHolder) {
          responseHolder.innerHTML = "";

          if(response.hasOwnProperty('errors')) {
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
          } 
          else {
              var successContainer = document.createElement('div');

              successContainer.innerText = 'Успешно променихте';
              successContainer.className = 'alert alert-success';
              responseHolder.appendChild(successContainer);
              setInterval(function(){ responseHolder.innerHTML=''; }, 3000);
          }          
        });

        if(!(response.hasOwnProperty('errors'))) {
          if (nameForm === 'addPrice') {
            var select = collectionSelects[0];
            var tableId = document.querySelector('#' + select.options[select.selectedIndex].value + ' tbody');

            tableId.innerHTML += response.success;
          } 
          else if(nameForm === 'sendUser') {
            if(response.place === 'active') {
              var table = document.getElementById('user-substitute-active');
              var tableBody = table.querySelector('tbody');

              tableBody.innerHTML += response.success;
            }
            else if(response.place === 'inactive') {
              var table = document.getElementById('user-substitute-inactive');
              var tableBody = table.querySelector('tbody');

              tableBody.innerHTML += response.success;
            } 
          }
          else {
            if(nameForm === 'addRepair') {
              var repairId = response.id,
              certificateButton = document.querySelector('button#certificate');

              certificateButton.dataset.repairId = repairId;
              certificateButton.disabled = false;
            }

            var tableBody = document.querySelector('table.table tbody');

            tableBody.innerHTML += response.success;
            
            elements.forEach(function (el) {
              var elType = el.getAttribute('type');

              if(typeof el != null && elType !== 'hidden' && typeof(el.dataset.clear) == 'undefined') {
                if(elType == 'checkbox') {
                  el.checked = false;
                }

                el.value = '';

                if(el.tagName == 'SELECT') {
                  $(el).val(null).trigger('change');
                }
               
                setTimeout(function(){  el.value = ''; }, 100);
                
                if(elType == 'file'){
                  $(el).parent().find('drop-area-input').val('');
                  $(el).val('');

                  var gallery = $(el).parent().children('.drop-area-gallery');
                  gallery.html('');     
                }     
              }
            });
        }

          $self.checkAllForms();
          editAction();
        }

        pendingRequest = false;
      }

      function handleUpdateResponse(response, elements, currentPressedBtn) {
        var alertAreas = [].slice.apply(document.getElementsByClassName('info-cont'));

        alertAreas.forEach(function(responseHolder) {
          var dropAreaGallery = responseHolder.parentElement.querySelector('.drop-area-gallery');
          var uploadedArea = responseHolder.parentElement.querySelector('.uploaded-images-area');
          var photos = response.photos;

          responseHolder.innerHTML = "";          
    
          if(dropAreaGallery!==null){
            dropAreaGallery.innerHTML = '';
          }
    
          if((!photos) && (photos !== undefined) && (photos.length > 0)){
            uploadedArea.innerHTML = response.photos;
            $self.dropFunctionality();
          }

          if(response.hasOwnProperty('errors')) {
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
          } 
          else {
              var successContainer = document.createElement('div');

              successContainer.innerText = 'Успешно променихте';
              successContainer.className = 'alert alert-success';
              responseHolder.appendChild(successContainer);
              setInterval(function(){ responseHolder.innerHTML=''; }, 3000);
          }
        });

        if(!(response.hasOwnProperty('errors'))) {
          var content = response.table.replace('<tr>', '').replace('</tr>', '');
  
          if(response.ID) {
            var id = response.ID;
            var tableRow = $('table tr');

            for(var row of tableRow) {
              var dataID = $(row).attr('data-id');
                    
              if(Number(dataID) == Number(id)){
                var tableRow = row;
              }
            }
          }
          else {
            var tableRow = $self.currentPressedBtn.parentElement.parentElement;
            $self.currentPressedBtn.removeEventListener('click', $self.clickEditButton);

          }

          if((nameForm === 'sendUser') && (response.place === 'inactive')){
            var container = document.createElement('table');
            container.innerHTML = response.table;
            var responseDataID = container.rows[0].getAttribute('data-id');
            var activeTable = document.getElementById('user-substitute-active');
            var activeTableRows = activeTable.rows;

            for(var row of activeTableRows){
              if(responseDataID === row.getAttribute('data-id')){
                activeTable.deleteRow(row.rowIndex);
              }
            }

            var table = document.getElementById('user-substitute-inactive');
            var tableBody = table.querySelector('tbody');

            tableBody.innerHTML += response.table;
          }
          else if(tableRow !== null){
            tableRow.innerHTML = content;
          }               
        }

        $self.checkAllForms();
        editAction();
        pendingRequest = false; 
      }

      $('#editStore').on('loaded', function () {
        e.preventDefault();
      });
      
      function editAction() {
        var collectionEditBtns = [].slice.apply(document.querySelectorAll('.edit-btn'));
  
        collectionEditBtns.forEach(function (btn) {
          $(btn).off();
          $(btn).on('click',clickEditButton);
        });
      }
  
      function clickEditButton(event) {
        event.preventDefault();

        var link = event.currentTarget;
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/' + urlTaken[3] + '/';
        var linkAjax = url+link.getAttribute('data-url');

        ajaxFn("GET", linkAjax, editBtnSuccess, '', '', this);        
        $self.currentPressedBtn = this;  
        setTimeout(function() {
          $self.checkAllForms(currentPressedBtn);
          $('#editModel [name="default_material[]"]:checked').closest('.form-row').find('.material_type').trigger('change');
        }, 500);

        setTimeout(function () {
          $('input.stone-flow:checked').trigger('change');
          $('#editProduct [name="material"]').trigger('change');
        }, 700);
      }

      function editBtnSuccess(data, elements, btn) {
         var id = btn.getAttribute("data-target");
         var selector = id + ' '+ '.modal-content';
         var html = $.parseHTML(data);
         var table = btn.parentElement.closest('table');
         var tableId = table.getAttribute('id');

         if(tableId === 'user-substitute-inactive'){
          var dateToInput = $(html).children().find('input[name=dateTo]');
          var dateFromInput = $(html).children().find('input[name=dateFrom]');

          dateToInput.attr('disabled', 'disabled');
          dateFromInput.attr('disabled', 'disabled');
         }

         $(selector).html(html);

         //here
         $self.initializeSelect($(selector).children().find('select'));

         $self.addAndRemoveFieldsMaterials();
         $self.addAndRemoveFieldsStones();
      }

      $self.addAndRemoveFieldsStones(); 
      $self.addAndRemoveFieldsMaterials();
    }
    
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
  
  var select_input = $('#jewel');
  var disabled_input = $('.disabled-first');

  if ($(this).find(':checked').val() !== '') {
    disabled_input.removeAttr('disabled');
  } else {

    disabled_input.prop('disabled', true);
    disabled_input.prop('selectedIndex', 0);
  }

  select_input.on('change', function () {
    if ($(this).find(':checked').val() !== '') {
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