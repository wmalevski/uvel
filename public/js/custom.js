var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window),
      currentPressedBtn;

    this.init = function () {
      $self.initializeSelect($('select'));
      $self.checkAllForms();     
    };

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

    this.initializeSelect = function (select) {
      select.select2({
        templateResult: $self.addSelect2CustomAttributes,
        templateSelection: $self.addSelect2CustomAttributes
      });
    }

    this.addAndRemoveFields = function () {

      var collectionAddFieldBtn = $('.add_field_button');

      collectionAddFieldBtn.each(function() {

        var thisBtn = $(this);
        var fieldsWrapper = $(this).parents().find('.model_stones');

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
              '<input type="text" class="form-control" name="stone_amount[]" placeholder="Брой">' +
              '</div>' +
              '<div class="form-group col-md-2">' +
              '<span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>'+
          '</div>';

            fieldsHolder.innerHTML = newFields;
            fieldsWrapper.append(fieldsHolder);

            $self.initializeSelect(fieldsWrapper.find('select'));
          }
          
        });

        $(fieldsWrapper).on('click', '.remove_field', function(event) {
          event.preventDefault();
          var parents = $(this).parentsUntil(".form-row .fields");
          parents[1].remove();
        });
        

      });
      
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
            imageWrapper.setAttribute("class", "image-wrapper");
            var closeBtn = document.createElement('div');
            closeBtn.setAttribute("class", "close");
            closeBtn.innerHTML = '&#215;';
            var img = document.createElement('img');
    
            img.src = reader.result;

            toDataURL(
              reader.result,
              function(dataUrl) {
                var data = dataUrl.replace('data:image/png;base64,',''); 
                instanceFiles.push(data);          
              }
            )   
            
            closeBtn.addEventListener('click', deleteUploadedImage);

            $(closeBtn).appendTo(imageWrapper);

            $(img).appendTo(imageWrapper);

            $(imageWrapper).appendTo(dropAreaGallery);

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
      var collectionModalEditBtns = document.querySelectorAll('.modal-dialog .modal-footer .edit-btn-modal');
      var collectionModalAddBtns = document.querySelectorAll('.modal-dialog .modal-footer .add-btn-modal');
      var collectionScanRepairBtns = document.querySelectorAll('.scan-repair');
      var collectionReturnRepairBtns = document.querySelectorAll('.return-repair');
      var printBtns = document.querySelectorAll('.print-btn');
      var deleteBtns = document.querySelectorAll('.delete-btn');
      var certificateBtns = document.querySelectorAll('.certificate');
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
      var moreProductsInput = document.getElementById("amount_check");
      var discountInput = document.getElementById("add_discount");
      var discountCardInput = document.getElementById("discount_card");
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

        console.log('calculating..');
        console.log(typeJeweryData);
        console.log(weightData);
        console.log(priceData);
        console.log('/calculating..');
        
        var inputDev = element.children().find('.worksmanship_price'),
          inputPrice = element.children().find('.final_price');

        if (typeJeweryData && priceData && weightData) {
          var priceDev = (priceData - typeJeweryData) * weightData;
          var productPrice = (priceData * weightData);

          inputDev.val(priceDev);
          inputPrice.val(productPrice);

          console.log('isndei');
        } else {
          inputDev.val('0');
          inputPrice.val('0');
        }
      }

      var jeweryPrice = 0;
      var dataWeight = 0;
      var priceDev = 0;

      $(document).on('change' , '.calculate' , function(e) {
        var _element = $(e.currentTarget);
        var ajaxUrl = window.location.origin + '/ajax/getPrices/';
        var parentElement = _element.parents('form');

        if(_element[0].nodeName == 'SELECT') {
          if(_element[0].id == 'jewel' || _element[0].id == 'jewel_edit') {
            var materialType = _element.find(':selected').attr('data-material');
            var requestLink = ajaxUrl + materialType;    

            jeweryPrice = _element.find(':selected').attr('data-pricebuy');

            ajaxFn('GET' , requestLink , function(response) {
                var data = response.prices;
  
                var newData = data.map(function(keys) {
                  return {
                    id: keys.id,
                    text: keys.slug + ' - ' + keys.price,
                    price: keys.price,
                    material: keys.material
                  }
                });
                
                _element.parents('form').children().find('.prices-filled').empty();
                _element.parents('form').children().find('.prices-filled').select2({
                  data: newData,
                  templateResult: $self.addSelect2CustomAttributes,
                  templateSelection: $self.addSelect2CustomAttributes
                });              
              });  
          } else {
            priceDev = _element.select2('data')[0].price;
          }

          calculatePrice(jeweryPrice , dataWeight , priceDev , parentElement);
        } else {
          dataWeight = _element[0].value;
          calculatePrice(jeweryPrice , dataWeight , priceDev , parentElement);
        }
      });

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

      if(collectionModalEditBtns.length > 0) {

        var modelSelect = $('#model_select');
        var typeSelect;
        var collectionFiles = [];
        var dropZone = document.getElementsByClassName("drop-area");
        
        if(dropZone) {
            this.dropFunctionality(collectionFiles);   
        }

        if(modelSelect) {
          modelSelect.on('select2:select', function(ev) {
            
            if(modelSelect.val()) {
              
              var value = modelSelect.find(':selected').val(),
                  tempUrl = url + '/products/' + value,
                  xhttp = new XMLHttpRequest(),
                  typeSelect = $('#jewel_edit');

              typeSelect.on('select2:select', function(ev) {
                modelSelect.val('0').trigger('change.select2');
              });

              productsRequest(tempUrl);
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
          modelSelect.on('select2:select', function(ev) {
            if(modelSelect.val()) {
              var value = modelSelect.find(':selected').val(),
                  tempUrl = url + '/products/' + value,
                  xhttp = new XMLHttpRequest(),
                  typeSelect = $('#jewel');

            
                  
              typeSelect.on('select2:select', function(ev) {
                modelSelect.val('0').trigger('change.select2');
              });

              productsRequest(tempUrl);
              
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

      if(catalogNumberInput !== null) {
        catalogNumberInput.addEventListener('change', addCatalogNumber);
      }

      function addCatalogNumber() {
        var catalogNumber = this.value;
        var amountValue = amountInput.value;
        var amountCheck = moreProductsInput.checked;
        var ajaxUrl = sellingForm.getAttribute("data-scan");
        var dataSend = {'catalog_number' : catalogNumber, 'quantity' : Number(amountValue), 'amount_check' : amountCheck};

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

        moreProductsInput.addEventListener('click', moreProductsSelected)

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
        numberItemInput.addEventListener('change',sendItem);
      }

      function sendItem(event) {
         var numberItemValue = this.value;
         var amountValue = amountInput.value;
         var amountCheck = moreProductsInput.checked;

         if(numberItemValue.length == 13){
           var dataSend = {'barcode' : Number(numberItemValue), 'quantity' : Number(amountValue), 'amount_check' : amountCheck};
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

          ajaxFn("GET",ajaxUrl,sendProcessRepairBarcodeSuccess,'','',processReturnBarcodeInput);
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
        if(event.target && event.target.parentElement.classList.contains('print-btn')) {
          event.preventDefault();
          event.stopPropagation();

          var urlTaken = event.target.parentElement.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
          var link = event.target.parentElement;
          var linkPath = link.href.split("admin")[1];
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

      function deleteRowRecord(event) {    
        if(event.target && event.target.parentElement.classList.contains('delete-btn')) {
          event.preventDefault();
          event.stopPropagation();

          if (confirm("Сигурен ли си, че искаш да изтриеш записа?")) {
            var urlTaken = event.target.parentElement.href.split('/');
            var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax';
            var link = event.target.parentElement;
            var linkPath = link.href.split("admin")[1];
            var ajaxUrl = url+linkPath;

            ajaxFn("POST",ajaxUrl,deleteBtnSuccess,'','',link);
          }       
        }
      }

      function deleteBtnSuccess(data, elements, btn) {
      
        let td = btn.parentElement;
        let tr = td.parentElement;
        let table = tr.parentElement;

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
            //collectionInputs = [].slice.apply(document.forms[nameForm].getElementsByTagName('input'));
            collectionInputs = [].slice.apply(form.getElementsByTagName('input'));
            collectionTextareas = [].slice.apply(document.forms[nameForm].getElementsByTagName('textarea'));              
            //collectionSelects = [].slice.apply(document.forms[nameForm].getElementsByTagName('select'));
            collectionSelects = [].slice.apply(form.getElementsByTagName('select'));
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
        
                      //collectionData[name] = [].slice.apply(collectionFiles);
                      
                      var images = [];
                      var uploadedImages = $(el).parent().find('.drop-area-gallery').children();

                      for(var i=0; i<uploadedImages.length; i++){

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

                      if (collectionData.hasOwnProperty(name)) {
                        collectionData[name].push(value);

                      } 
                      else {
                        collectionData[name] = [value];
                      }

                      collectionElements.push(el);

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
      

      /*end getFormData() */

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
                          
                          option.setAttribute('data-pricebuy' , el.pricebuy || 0);

                      if(el.price) {
                        console.log('TRUE');
                        option.setAttribute('data-price' , el.price || 0);
                      }

                      
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

            //var data = JSON.parse(this.responseText);
            
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

              if(el.tagName == 'SELECT') {
                $(el).val(null).trigger('change');
              }

              el.value = '';

              if(elType == 'file'){

                $(el).parent().find('drop-area-input').val('');

                $(el).val('');

                var gallery = $(el).parent().children('.drop-area-gallery');
                gallery.html('');
                      
              }     
              

            }

          })
        }

        editAction();

        pendingRequest = false;

      }

      function handleUpdateResponse(response, elements, currentPressedBtn) {
        var alertAreas = document.getElementsByClassName('info-cont');

        Array.from(alertAreas).forEach(function(responseHolder) {
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
          } else {
  
              var successContainer = document.createElement('div');
                  successContainer.innerText = 'Успешно променихте';
                  successContainer.className = 'alert alert-success';
              var content = response.table.replace('<tr>', '').replace('</tr>', '');

              responseHolder.appendChild(successContainer);
  
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
             
                if(tableRow !== null){
                  tableRow.innerHTML = content;
                }
                
                var dropAreaGallery = responseHolder.parentElement.querySelector('.drop-area-gallery');
                var uploadedArea = responseHolder.parentElement.querySelector('.uploaded-images-area');
                var photos = response.photos;
  
                if(dropAreaGallery!==null){
                  dropAreaGallery.innerHTML = '';
                }
  
                if((!photos) && (photos !== undefined) && (photos.length > 0)){
                  uploadedArea.innerHTML = response.photos;
                  $self.dropFunctionality();
                }
                
                editAction();
          }
        });

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

        var link = event.target.parentElement;

        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/' + urlTaken[3] + '/';

        var linkAjax = url+link.getAttribute('data-url');

        ajaxFn("GET", linkAjax, editBtnSuccess, '', '', this);
              
        $self.currentPressedBtn = this;  
        
        setTimeout(function() {$self.checkAllForms(currentPressedBtn);}, 500);

      }
      

      function editBtnSuccess(data,elements,btn) {

         var id = btn.getAttribute("data-target");
         var selector = id + ' '+ '.modal-content';
         var html = $.parseHTML(data);

         $(selector).html(html);      
         $self.initializeSelect($(selector).children().find('select'));
      }

      $self.addAndRemoveFields(); 
 
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