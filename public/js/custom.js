var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window),
      currentPressedBtn;

    this.init = function () {
      $self.initializeSelect($('select'));
      $self.addAndRemoveFields();
      $self.checkAllForms();
    };

    this.initializeSelect = function (select) {

      select.select2();
    }

    this.addAndRemoveFields = function () {

      var collectionAddFieldBtn = $('.add_field_button');

      collectionAddFieldBtn.each(function() {

        var thisBtn = $(this);
        var fieldsWrapper = $(this).parents().find('.model_stones');

        thisBtn.on('click', function (e) {
          
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

        $(fieldsWrapper).on('click', '.remove_field', function(e) {

          e.preventDefault();
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
            var img = document.createElement('img');
    
            img.src = reader.result;

            toDataURL(
              reader.result,
              function(dataUrl) {
                var data = dataUrl.replace('data:image/png;base64,',''); 
                instanceFiles.push(data);          
              }
            )


            closeBtn.innerHTML = '&#215;';

            closeBtn.onclick = function() {
              this.parentElement.remove();


            }

            $(closeBtn).appendTo(imageWrapper);

            $(img).appendTo(imageWrapper);

            $(imageWrapper).appendTo(dropAreaGallery);
 
            //$(img).appendTo(dropAreaGallery);

          }
        }

  
      });

        
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

    /*
    function deleteImage(e) {

          e.preventDefault();

          console.log('delete');

    }
    */



    this.checkAllForms = function(currentPressedBtn) {    

      var collectionModalEditBtns = document.querySelectorAll('.modal-dialog .modal-footer .edit-btn-modal');
      var collectionModalAddBtns = document.querySelectorAll('.modal-dialog .modal-footer .add-btn-modal');

      var printBtns = document.querySelectorAll('.print-btn');
      var deleteBtns = document.querySelectorAll('.delete-btn');

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

      var collectionModelPrice = [].slice.apply(document.querySelectorAll('.calculate'));
      var collectionFillFields = [].slice.apply(document.querySelectorAll('.fill-field'));

      var pendingRequest = false;

      editAction();
      

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

      if(collectionModalEditBtns.length > 0){

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
                  typeSelect = $('#jewels_types');

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
     

      if(collectionModalAddBtns.length > 0){

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
                  typeSelect = $('#jewels_types');

              typeSelect.on('select2:select', function(ev) {
                modelSelect.val('0').trigger('change.select2');
              });

              productsRequest(tempUrl);
            }
          });
        }
          
        collectionModalAddBtns.forEach(function (btn) {
          //btn.removeEventListener('click', getFormData, true);
          //btn.addEventListener('click', getFormData); 

          $(btn).off();

          $(btn).on('click', getFormData); 

        });
      }

      if(catalogNumberInput !== null){
        catalogNumberInput.onchange = addCatalogNumber;
      }

      function addCatalogNumber(){

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
        discountCardInput.onchange = addCardDiscount;
      }

      function addCardDiscount() {

        var discountCardBarcode = this.value;
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax/';
        var discountUrl = discountInput.getAttribute("data-url");

        if(discountCardBarcode.length == 13){

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

        if(barcode.length > 0){

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

        moreProductsInput.onclick = function() {
          
          if(this.checked ) {
            amountInput.readOnly = false;
          } 
          else {
            amountInput.readOnly = true;
          }

        };

     }
      

      if(sellingForm !== null){
      
        sellingForm.onsubmit = function(e){
            e.preventDefault();
        };
  
      }  

      if(numberItemInput !== null){
        numberItemInput.onchange = sendItem;
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

      function sendSuccess(data, elements, btn){

        var success = data.success;
        var subTotalInput = document.getElementById("subTotal");
        var totalInput = document.getElementById("total");
        var barcodeInput = document.getElementById("product_barcode");
        var html = data.table;
        //var html = $.parseHTML(data.table);
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

      if(barcodeProcessRepairInput !== null){
        barcodeProcessRepairInput.onchange = sendProcessRepairBarcode;
      }

      function sendProcessRepairBarcode(event) {

        var processRepairBarcode = event.target.value;
      
        if(processRepairBarcode.length > 0){

          var urlTaken = window.location.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs';
          var ajaxUrl = url + '/' + processRepairBarcode;

          ajaxFn("GET",ajaxUrl,sendProcessRepairBarcodeSuccess,'','','');
        } 

      }


      function sendProcessRepairBarcodeSuccess() {

        console.log("sendProcessRepairBarcodeSuccess");
      }

      if(barcodeReturnRepairInput !== null){
        barcodeReturnRepairInput.onchange = sendReturnRepairBarcode;
      }

      function sendReturnRepairBarcode(event){

        var processReturnBarcode = event.target.value;

        if(processReturnBarcode.length > 0){

          var urlTaken = window.location.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs/return';
          var ajaxUrl = url + '/' + processReturnBarcode;

          ajaxFn("GET",ajaxUrl,sendProcessReturnBarcodeSuccess,'','','');
        } 
      }

      function sendProcessReturnBarcodeSuccess(){

        console.log("sendProcessReturnBarcodeSuccess");

      }



      document.addEventListener('click', print);
      document.addEventListener('click', deleteRowRecord);
  
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

        var originalPageContent = document.body.innerHTML;

        if(data.success){
          document.body.innerHTML = data.html;
          window.print();
          document.body.innerHTML = originalPageContent;
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


        var responseHolder = document.forms[nameForm].firstElementChild.nextElementSibling.firstElementChild;

        responseHolder.innerHTML = '';
       
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

              responseHolder.appendChild(successContainer);

              var content = response.table.replace('<tr>', '').replace('</tr>', '');

              var tableRow = $self.currentPressedBtn.parentElement.parentElement;

              $self.currentPressedBtn.removeEventListener('click', $self.clickEditButton);
  
              if(tableRow !== null){
                  tableRow.innerHTML = content;
              }
              
              editAction();

        }

        pendingRequest = false;
        
      }

      //edit buttons

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
        //event.stopPropagation();

        var link = event.target.parentElement;

        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/' + urlTaken[3] + '/';

        var linkAjax = url+link.getAttribute('data-url');

        ajaxFn("GET", linkAjax, editBtnSuccess, '', '', this);
              
        $self.currentPressedBtn = this;  
        
        setTimeout(function() {$self.checkAllForms(currentPressedBtn);}, 500);

        //event.stopImmediatePropagation();
  

      }
      

      function editBtnSuccess(data,elements,btn){

         var id = btn.getAttribute("data-target");
         var selector = id + ' '+ '.modal-content';
         var html = $.parseHTML(data);
         
         $(selector).html(html);

      }
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