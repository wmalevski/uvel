var uvel,
  uvelController = function() {
    var $self = this,
      $window = $(window),
      $body = $('body'),
      currentPressedBtn;

    this.formsConfig = {
      globalSettings: {
        token: $('meta[name="csrf-token"]').attr('content'),
        controllers: ['submitForm']
      },
      blog: {
        selector: '[name="blog"]',
        controllers: ['imageHandling'],
        initialized: false
      },
      discounts: {
        selector: '[name="discounts"]',
        controllers: ['lifetimeDiscount'],
        initialized: false
      },
      jewels: {
        selector: '[name="jewels"]',
        controllers: [],
        initialized: false
      },
      stores: {
        selector: '[name="stores"]',
        controllers: [],
        initialized: false
      },
      otherProductsTypes: {
        selector: '[name="productsOthersTypes"]',
        controllers: [],
        initialized: false
      },
      otherProducts: {
        selector: '[name="productsOthers"]',
        controllers: ['imageHandling'],
        initialized: false
      },
      materialTypes: {
        selector: '[name="materialsTypes"]',
        controllers: [],
        initialized: false
      },
      materials: {
        selector: '[name="materials"]',
        controllers: [],
        initialized: false
      },
      materialsQuantity: {
        selector: '[name="materialsQuantity"]',
        controllers: [],
        initialized: false
      },
      materailsTraveling: {
        selector: '[name="sendMaterial"]',
        controllers: [],
        initialized: false
      },
      prices: {
        selector: '[name="prices"]',
        controllers: [],
        initialized: false
      },
      currencies: {
        selector: '[name="currencies"]',
        controllers: [],
        initialized: false
      },
      substitutions: {
        selector: '[name="substitutions"]',
        controllers: ['focusDatePicker'],
        initialized: false
      },
      users: {
        selector: '[name="users"]',
        controllers: [],
        initialized: false
      },
      partners: {
        selector: '[name="partners"]',
        controllers: [],
        initialized: false
      },
      partnermaterials: {
        selector: '[name="partnermaterials"]',
        controllers: [],
        initialized: false
      },
      selling: {
        selector: '[name="selling"]',
        controllers: [
          'paymentInitializer',
          'getWantedSumInit'
        ],
        initialized: false
      },
      sellingPartners: {
        selector: '[name="sellingPartners"]',
        controllers: ['partnerPaymentInit'],
        initialized: false
      },
      stones: {
        selector: '[name="stones"]',
        controllers: [
          'calculateCaratsInitializer',
          'imageHandling'
        ],
        initialized: false
      },
      stoneStyles: {
        selector: '[name="stoneStyles"]',
        controllers: [],
        initialized: false
      },
      stoneContours: {
        selector: '[name="stoneContours"]',
        controllers: [],
        initialized: false
      },
      stoneSizes: {
        selector: '[name="stoneSizes"]',
        controllers: [],
        initialized: false
      },
      models: {
        selector: '[name="models"]',
        controllers: [
          'addMaterialsInit',
          'calculateRepairAfterPriceInit',
          'addStonesInit',
          'removeMaterialsInit',
          'removeStoneInit',
          'calculateStonesInit',
          'calculatePriceInit',
          'materialPricesRequestInit',
          'imageHandling'
        ],
        initialized: false
      },
      products: {
        selector: '[name="products"]',
        controllers: [
          'addStonesInit',
          'removeStoneInit',
          'calculateStonesInit',
          'calculatePriceInit',
          'materialPricesRequestInit',
          'imageHandling'
        ],
        select2obj: [{
          selector: 'select[name="model_id"]',
          callback: 'productsModelSelectCallback'
        }],
        initialized: false
      },
      productsTravelling: {
        selector: '[name="productsTravelling"]',
        controllers: ['productTravellingBarcodeInput'],
        select2obj: [{
          selector: 'select[name="product_select"]',
          callback: 'productTravellingSelectCallback'
        }],
        initialized: false
      },
      repairTypes: {
        selector: '[name="repairTypes"]',
        controllers: [],
        initialized: false
      },
      repairs: {
        selector: '[name="repairs"]',
        controllers: [
          'fillRepairPrice',
          'calculateRepairAfterPriceInit',
          'calculateRepairAfterPrice',
          'focusDatePicker'
        ],
        initialized: false
      },
      customOrders: {
        selector: '[name="custom_order"]',
        controllers: [],
        initialized: false
      },
      modelOrders: {
        selector: '[name="model_order"]',
        controllers: [],
        initialized: false
      },
      sliders: {
        selector: '[name="slides"]',
        controllers: ['imageHandling'],
        initialized: false
      },
      editPayments: {
        selector: '[name="editPayments"]'
      },
      orders: {
        selector: '[name="orders"]',
        controllers: [
          'addStonesInit',
          'addAnother',
          'manualReceipt',
          'barcodeInput',
          'removeMaterialsInit'
        ],
        select2obj: [{
          selector: 'select[name="model_id"]',
          callback: 'onOrdersFormSelectCallback'
        }],
        initialized: false
      },
      nomenclatures: {
        selector: '[name="nomenclatures"]',
        controllers: [],
        initialized: false
      },
      dailyReport: {
        selector: '[name="dailyReport"]',
        controllers: ['dailyReportAttach'],
        initialized: false
      },
      expenseTypes: {
        selector: '[name="expenseTypes"]',
        controllers: [],
        initialized: false
      },
      expenses: {
        selector: '[name="expenses"]',
        controllers: [],
        initialized: false
      },
      dailyReports: {
        selector: '[name="dailyReports"]',
        controllers: [],
        initialized: false
      }
    }

    this.init = function() {
      $self.attachInitialEvents();
      $self.initializeSelect($('select').not('[data-select2-skip]'));
      $self.initializeTableSort();
      // $self.checkAllForms();
    }

    this.attachInitialEvents = function() {
      var $openFormTrigger = $('[data-form]:not([data-repair-scan])'),
          $deleteRowTrigger = $('.delete-btn'),
          $printTrigger = $('.print-btn'),
          $barcodeProcessRepairTrigger = $('[data-repair-scan]'),
          $returnRepairBtn = $('[data-repair-return]'),
          $addNumberTrigger = $('[data-sell-catalogNumber], [data-sell-barcode]'),
          $sellMoreProductsTrigger = $('[data-sell-moreProducts]'),
          $addDiscountTrigger = $('[data-sell-discountApply]'),
          $addCardDiscountTrigger = $('[data-sell-discountCard]'),
          $travelingMaterialsStateBtns = $('[data-travelstate]'),
          $inputCollection = $('input'),
          $removeDiscountTrigger = $('[data-sell-removeDiscount]');

      $self.openForm($openFormTrigger);
      $self.deleteRow($deleteRowTrigger);
      $self.print($printTrigger);
      $self.barcodeProcessRepairAttach($barcodeProcessRepairTrigger);
      $self.returnRepairBtnAction($returnRepairBtn);
      $self.addNumber($addNumberTrigger);
      $self.sellMoreProducts($sellMoreProductsTrigger);
      $self.addDiscount($addDiscountTrigger);
      $self.removeDiscountAttach($removeDiscountTrigger);
      $self.addCardDiscount($addCardDiscountTrigger);
      $self.travellingMaterialsState($travelingMaterialsStateBtns);
      $self.enterPressBehaviour($inputCollection);
      $self.setInputFilters();
    }

    this.initializeTableSort = function() {
      var tables = document.querySelectorAll('table');

      for (var i = 0; i < tables.length; i++) {
        new Tablesort(tables[i]);
      }
    }

    this.dailyReportAttach = function() {
      var form = $('form[name="dailyReport"');
      var dailyReportTrigger = form.find('button[type="submit"]');

      dailyReportTrigger.on('click', function(e) {
        e.preventDefault();
        var ajaxUrl = form[0].dataset.scan;

        $.ajax({
          method: "POST",
          url: ajaxUrl,
          success: function(resp) {
            $self.formSuccessHandler(form, 'dailyReport', resp);
          },
          error: function(err) {
            $self.formsErrorHandler(err, form);
          }
        });
      });
    }

    this.openForm = function(openFormTrigger) {
      openFormTrigger.on('click', function() {
        $self.openFormAction($(this));
      });
    }

    this.calculateExpectedMaterial = function() {
      var materialHolder = document.querySelector('[data-expected-material]'),
          materials = document.querySelectorAll('[data-saleProduct]'),
          totalWeight = 0;

      for (var i = 0; i < materials.length; i++) {
        var materialCarat = Number(materials[i].querySelector('[data-carat]').dataset.carat);
        var materialWeight = parseFloat(materials[i].querySelector('[data-weight]').dataset.weight);
        totalWeight += (materialCarat / 14) * materialWeight;
      }

      materialHolder.dataset.expectedMaterial = Number(totalWeight.toFixed(2)) || 0;
    }

    this.openFormAction = function(currentPressedBtn, data) {
      var $this = currentPressedBtn,
          timeToOpenModal = 1000, //time which takes for modals to open
          openedForm = $this.attr('data-form'),
          formType = $this.attr('data-form-type'),
          formSettings = $self.formsConfig[openedForm]
          $submitButton = $('form[name="' + openedForm + '"]').find('button[type="submit"]');
          
      $submitButton.prop('disabled', true);
      
      if (formType == 'edit') {
        $self.appendingEditFormToTheModal($this, data);
      }

      if (formType == 'sell') {
        $self.calculateExpectedMaterial('[data-saleProduct]', 'expecteMaterial');
        $self.lockPaymentControllers();
        $self.checkOrder($('[data-type="' + formType + '"]'));
      } else if (formType == 'partner-sell') {
        var ajaxUrl = currentPressedBtn.attr('data-url');

        $self.ajaxFn('GET', ajaxUrl, $self.partnerPaymentLoad);
      }

      //TODO: ASK BOBI VVVV

      setTimeout(function() {
        if ((formType == 'add' || formType == 'sell' || formType == 'partner-sell') && !formSettings.initialized) {
          $self.initializeForm(formSettings, formType);
          formSettings.initialized = true;
        } else if (formType == 'edit') {
          $self.initializeForm(formSettings, formType);
        } else {
          // Form already initialized
          console.log('form already initialized');
        }
        $submitButton.prop('disabled', false);
      }, timeToOpenModal);
    }

    this.checkOrder = function(form) {
      var orderedProducts = document.querySelectorAll('#shopping-table [data-order-id]');

      if (orderedProducts.length) {
        //MAKE AJAX CALL
        $.ajax({
          method: 'GET',
          url: '/ajax/sell/order_materials',
          success: function(response) {
            $self.orderResponseHandler(form, response);
          },
          error: function(response) {
            console.log(response);
          }
        });
      }
    };

    this.orderResponseHandler = function(form, response) {
      var exchange = form.find('#exchange'),
          exchangeRow = form.find('#exchange-row'),
          exchangeFields = form.find('.exchange-row-fields'),
          materials = response.materials;

          $self.showExchangeRow(exchangeRow, newExchangeField, false);
          exchange.prop('checked', true);

      for (var i = 0; i < materials.length; i++) {
        var newField = $(newExchangeField);
              
        newField.find('[data-calculateprice-material]')
                .attr({
                  name: 'order_material_id[]',
                  disabled: true
                });

        newField.find('[data-weight]')
                .val(materials[i].weight)
                .attr({
                  'data-weight': materials[i].weight, 
                  disabled: true
                })
                .removeAttr('name');

        exchangeFields.append(newField);

        var materialFields = form[0].querySelectorAll('[data-calculateprice-material]'),
            materialHolder = materialFields[materialFields.length - 1];

        $self.addExchangeMaterial(materials[i], materialHolder, true);
      }
    }

    this.partnerPaymentLoad = function(response) {
      var form = document.querySelector('[name="sellingPartners"]'),
          materials = JSON.parse(response.materials),
          keys = Object.keys(materials),
          partner = response.partner.name,
          workmanship = response.workmanship,
          tableContent = '';

      for (var i = 0; i < keys.length; i++) {
        var partnerMaterialWeight = materials[keys[i]].partner_material_weight,
            materialId = materials[keys[i]].material_id,
            materialName = materials[keys[i]].name,
            materialWeight = materials[keys[i]].weight,
            partnerMaterialId = materials[keys[i]].partner_material;

        tableContent += '<tr data-material-id="' + materialId + '">';
        tableContent += '<td data-material-name>' + materialName + '</td>';
        tableContent += '<td data-material-weight>' + materialWeight + '</td>';
        tableContent += '<td data-material-partner="' + partnerMaterialId + '">' + partnerMaterialWeight || 0 + '</td>';
        tableContent += '<td><input type="number" class="form-control" value="0" data-material-given></td>';
        tableContent += '</tr>';
      }

      
      form.querySelector('.partner-information').innerHTML = partner;
      form.querySelector('tbody').innerHTML = tableContent;
      form.querySelector('#partner-wanted-sum').value = 0;
      form.querySelector('[data-worksmanship-wanted]').value = workmanship;
      form.querySelector('[data-worksmanship-given]').value = 0
    }

    this.partnerPaymentInit = function(form) {
      var wantedSumHolder = form[0].querySelector('[name="partner-wanted-sum"]'),
          wantedWorksmanship = form[0].querySelector('[data-worksmanship-wanted]'),
          givenWorksmanship = form[0].querySelector('[data-worksmanship-given]'),
          paymentMethod = form[0].querySelector('[name="partner-pay-method"]');

      wantedSumHolder.value = wantedWorksmanship.value;

      paymentMethod.addEventListener('click', function() {
        if (this.checked) {
          givenWorksmanship.readOnly = true;
          wantedSumHolder.value = 0;
          givenWorksmanship.value = wantedWorksmanship.value;
        } else {
          givenWorksmanship.readOnly = false;
          givenWorksmanship.value = 0;
          wantedSumHolder.value = wantedWorksmanship.value;
        }
      }, false);

      givenWorksmanship.addEventListener('change', function() {
        var total = parseFloat(wantedWorksmanship.value) - (parseFloat(givenWorksmanship.value) || 0);
        wantedSumHolder.value = Number(total.toFixed(2));
      }, false);
    }

    this.enterPressBehaviour = function(inputs) {
      inputs.on('keypress', function(event) {
        if (event.which == 13) {
          event.preventDefault();
          $(this).trigger('change');
          $(this).blur();
        }
      });
    }

    this.deleteRow = function(deleteRowTrigger) {
      deleteRowTrigger.on('click', function() {
        var _this = $(this),
            ajaxRequestLink = _this.hasClass('cart') ? _this.attr('data-url') : $self.buildAjaxRequestLink('deleteRow', _this.attr('data-url'));

        if (confirm('Сигурен ли сте, че искате да изтриете записа?')) {
          $.ajax({
            method: 'POST',
            url: ajaxRequestLink,
            success: function(response) {
              if (_this.hasClass('cart')) {
                $self.cartSumsPopulate(response);
                $self.calculateExpectedMaterial('[data-saleProduct]', 'expectedMaterial');
              }

              _this.parents('tr').remove();
            },
            error: function(response) {
              var errors = response.responseJSON.errors,
                  stayingTime = 3000;

              for (var key in errors) {
                var errorText = errors[key][0],
                    errorDiv = document.createElement('div'),
                    table = _this.closest('table');

                errorDiv.innerHTML = errorText;
                $(errorDiv).addClass('alert alert-danger table-alert');
                table.parent().prepend(errorDiv);

                setTimeout(function() {
                  $(errorDiv).remove();
                }, stayingTime);
              }
            }
          });
        }
      })
    }

    this.addNumber = function(addNumberTrigger) {
      addNumberTrigger.on('change', function() {
        var _this = $(this),
            sellingForm = _this.closest('form'),
            number = _this.val(),
            moreProductsChecked = sellingForm.find('[data-sell-moreProducts]').is(':checked'),
            productsAmount = Number(sellingForm.find('[data-sell-productsAmount]').val()),
            typeRepair = sellingForm.find('[data-sell-repair]').is(':checked'),
            ajaxUrl = sellingForm.attr('data-scan'),
            dataSend;

        if (_this[0].hasAttribute('data-sell-catalogNumber')) {
          dataSend = {
            'catalog_number': number,
            'quantity': productsAmount,
            'amount_check': moreProductsChecked,
            'type_repair': typeRepair
          };
        } else if (_this[0].hasAttribute('data-sell-barcode') && number.length == 13) {
          dataSend = {
            'barcode': Number(number),
            'quantity': productsAmount,
            'amount_check': moreProductsChecked,
            'type_repair': typeRepair
          };
        }

        $self.ajaxFn('POST', ajaxUrl, $self.numberSend, dataSend, '', '');
        _this.val('');
      })
    }

    this.numberSend = function(response) {
      var success = response.success,
          html = response.table,
          shoppingTable = $('#shopping-table');

      if (success) {
        shoppingTable.find('tbody').html(html);
        $self.cartSumsPopulate(response);
        var deleteRowTrigger = $('.delete-btn');
        $self.deleteRow(deleteRowTrigger);
      } else {
        var errors = response.errors,
            stayingTime = 3000;

        for (var key in errors) {
          var error = errors[key],
              errorDiv = $('<div class="alert alert-danger table-alert"></div>');

          errorDiv.append(error);
          $('#mainContent').prepend(errorDiv);
          setTimeout(function() {
            errorDiv.remove();
          }, stayingTime);
        }
      }
    }

    this.sellMoreProducts = function(sellMoreProductsTrigger) {
      sellMoreProductsTrigger.on('change', function() {
        var amountInput = $('[data-sell-productsAmount]');
        if ($(this).is(':checked')) {
          amountInput.removeAttr('readonly');
        } else {
          amountInput.attr('readonly', 'readonly');
          amountInput.val('1');
        }
      });
    }

    this.addDiscount = function(addDiscountTrigger) {
      addDiscountTrigger.on('click', function(e) {
        e.preventDefault();
        var _this = $(this),
            discountInput = _this.closest('form').find('[data-sell-discount]'),
            discountAmount = Number(discountInput.val()),
            description = _this.closest('form').find('[data-sell-description]').val(),
            urlTaken = window.location.href.split('/'),
            _url = urlTaken[0] + '//' + urlTaken[2] + '/ajax/',
            discountUrl = _this.attr('data-url'),
            dataSend = {
              'discount': discountAmount,
              'description': description
            };

        if (discountAmount > 0) {
          var ajaxUrl = _url + discountUrl;
          $self.ajaxFn('POST', ajaxUrl, $self.discountSuccess, dataSend, '', '');
        }
      });
    }

    this.addCardDiscount = function(addCardDiscountTrigger) {
      addCardDiscountTrigger.on('change', function() {
        var _this = $(this),
            discountBarcode = _this.val(),
            urlTaken = window.location.href.split('/'),
            _url = urlTaken[0] + '//' + urlTaken[2] + '/ajax/',
            discountUrl = _this.attr('data-url');

        if (discountBarcode.length == 13) {
          var ajaxUrl = _url + discountUrl + discountBarcode;

          $self.ajaxFn('GET', ajaxUrl, $self.discountSuccess, '', '', '');
          _this.val('');
        }
      });
    }

    this.discountSuccess = function(response) {
      var discountsHolder = $('.discount--label-holder'),
          isPartner = false;

      if (response.success) {
        var discounts = response.condition,
            newFields = '';

        for (key in discounts) {
          var discount = discounts[key];

          var newDiscount = '<span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">' +
              discount.value + '</span><span data-url="/ajax/removeDiscount/' +
              discount.attributes.discount_id + '" data-sell-removeDiscount class="discount-remove badge bgc-red-50 c-red-700 p-10 lh-0 tt-c badge-pill">' +
              '<i class="c-brown-500 ti-close"></i></span><br/>';

          newFields += newDiscount;

          if (discount.attributes.partner == 'true') {
            isPartner = true;
          }
        }

        $self.checkSellingFormType(isPartner);

        discountsHolder.html(newFields);
        $self.cartSumsPopulate(response);
        var removeDiscountTrigger = $('[data-sell-removeDiscount]');
        $self.removeDiscountAttach(removeDiscountTrigger);
      }
    }

    this.checkSellingFormType = function(isPartner) {
      var regularSellBtn = document.querySelector('[data-target="#paymentModal"]'),
          partnerSellBtn = document.querySelector('[data-target="#paymentPartner"]');

      if (isPartner && regularSellBtn.style.display != 'none') {
        regularSellBtn.style.display = 'none';
        partnerSellBtn.style.display = 'initial';
      } else if (!isPartner && partnerSellBtn.style.display != 'none') {
        regularSellBtn.style.display = 'initial';
        partnerSellBtn.style.display = 'none';
      }
    }

    this.cartSumsPopulate = function(response) {
      var subTotalInput = $('[data-sell-subTotal]'),
          discountDisplay = $('[data-sell-discountDisplay]'),
          totalInput = $('[data-calculatePayment-total]'),
          taxInput = $('[data-sell-tax]');

      subTotalInput.val(response.subtotal);
      totalInput.val(response.total);
      taxInput.val(response.dds);

      var discountsSum = response.subtotal - response.total;
      discountsSum = Math.round(discountsSum * 100) / 100;
      discountDisplay.val(discountsSum);
    }

    this.removeDiscountAttach = function(removeDiscountTrigger) {
      removeDiscountTrigger.on('click', function() {
        $self.removeDiscount($(this));
      });
    }

    this.removeDiscount = function(btn) {
      var ajaxUrl = btn.attr('data-url');
      $self.ajaxFn('GET', ajaxUrl, $self.discountSuccess, '', '', '');
    }

    this.initializeForm = function(formSettings, formType) {
      var form = $(formSettings.selector + '[data-type="' + formType + '"]'),
          customControllers = formSettings.controllers,
          select2obj = formSettings.select2obj;

      $self.initializeGlobalFormControllers(form);
      $self.initializeControllers(customControllers, form);
      if (select2obj) {
        $self.setSelect2(select2obj, form);
      }
    }

    this.initializeGlobalFormControllers = function(form) {
      $self.initializeControllers($self.formsConfig.globalSettings.controllers, form);
    }

    this.initializeControllers = function(controllers, form) {
      controllers.forEach(function(controller) {
        $self[controller](form);
      });
    }

    this.setSelect2 = function(select2obj, form) {
      for (var i = 0; i < select2obj.length; i++) {
        var currentSelectObject = select2obj[i],
            selector = currentSelectObject.selector,
            callback = currentSelectObject.callback,
            selectElement = form.find(selector);

        selectElement.on('select2:select', function(event) {
          $self[callback](event, selectElement, form);
        });
      }
    }

    this.submitForm = function(form) {
      var submitButton = form.find('[type="submit"]'),
          ajaxRequestLink = $self.buildAjaxRequestLink('submitForm', form.attr('action')),
          formType = form.attr('data-type');

      submitButton.click(function(e) {
        e.preventDefault();
        
        this.disabled = true;
        
        if (formType == 'partner-sell') {
          $self.partnerPaymentSubmit(form, ajaxRequestLink, formType);
        } else {
          var inputFields = form.find('select , input, textarea');
          $self.getFormFields(form, ajaxRequestLink, formType, inputFields);
        }
      });
    }

    this.partnerPaymentSubmit = function(form, ajaxRequestLink, formType) {
      var materials = form.find('[data-material-id]'),
          workmanshipWanted = form.find('[data-worksmanship-wanted]').val(),
          workmanshipGiven = form.find('[data-worksmanship-given]').val(),
          receiptOptions = form.find('[type="radio"]'),
          payMethod = form.find('[name="partner-pay-method"]')[0].checked,
          data = {
            _token: $self.formsConfig.globalSettings.token,
            isPartner: true,
            payMethod: payMethod,
            workmanship: {
              wanted: workmanshipWanted,
              given: workmanshipGiven
            },
            materials: []
          };

      for (var i = 0; i < materials.length; i++) {
        var material_id = materials[i].dataset.materialId,
            material_partner_id = materials[i].querySelector('[data-material-partner]').dataset.materialPartner,
            material_weight = materials[i].querySelector('[data-material-weight]').textContent,
            material_given = materials[i].querySelector('[data-material-given]').value;

        var material = {
          material_partner_id: material_partner_id,
          material_id: material_id,
          material_weight: material_weight,
          material_given: material_given
        };

        data.materials.push(material);
      }

      for (var i = 0; i < receiptOptions.length; i++) {
        if (receiptOptions[i].checked) {
          data[receiptOptions[i].id] = true;
        }
      }

      $self.sendFormRequest(form, ajaxRequestLink, formType, data);
    }

    this.getFormFields = function(form, ajaxRequestLink, formType, inputFields) {
      var data = {
            _token: $self.formsConfig.globalSettings.token
          },
          imageCollection = [];

      if (formType == 'edit') {
        data._method = 'PUT';
      }

      inputFields.each(function(index, element) {
        var inputType = element.type,
            dataKey = element.name,
            dataKeyValue = element.value,
            imagesInputFieldExists = dataKey == 'images' ? true : false;

        if ((inputType == 'radio' || inputType == 'checkbox') && dataKey.indexOf('[]') !== -1) {
          dataKey = dataKey.replace('[]', '');
          (data[dataKey] = data[dataKey] || []).push($(element).is(':checked'));
        } else if (inputType == 'radio' || inputType == 'checkbox') {
          data[dataKey] = $(element).is(':checked');
        } else if (dataKey.indexOf('[]') !== -1) {
          dataKey = dataKey.replace('[]', '');
          (data[dataKey] = data[dataKey] || []).push(dataKeyValue);
        } else {
          data[dataKey] = dataKeyValue;
        }

        if (imagesInputFieldExists) {
          var imagesHolder = $('.drop-area-gallery .image-wrapper img');

          imagesHolder.each(function(index, element) {
            var imgSource = element.getAttribute('src');
            imageCollection.push(imgSource);
          });

          data.images = imageCollection;
        }
      });

      $self.sendFormRequest(form, ajaxRequestLink, formType, data);
    }

    this.clearForm = function(form, formType) {
      var inputsSelector = 'input[type="text"]:not(.not-clear), ' +
          'input[type="number"]:not(.not-clear), ' +
          'input[type="password"]:not(.not-clear), ' +
          'input[type="email"]:not(.not-clear), ' +
          'input[type="checkbox"]:not(.not-clear),' +
          'textarea:not(.not-clear)';

      var textInputs = form.find(inputsSelector),
          radios = form.find('input[type="radio"]:not(.not-clear)'),
          radiosNotToClear = form.find('input[type="radio"].not-clear'),
          selects = form.find('select:not(.not-clear)'),
          stoneRowsContainer = form.find('.model_stones'),
          imagesContainer = form.find('.drop-area-gallery'),
          materialsContainer = form.find('.model_materials'),
          formName = form.attr('name');

      for (var i = 0; i < textInputs.length; i++) {
        var element = textInputs[i];
        
        if (element.type == 'number') {
          element.value = 0;
        } else if (element.type == 'checkbox' && element.checked) {
            $(element).prop('checked', false).change();
        } else {
          element.value = '';
        }
      }

      radios.prop('checked', false);
      radiosNotToClear.prop('checked', true);

      for (var i = 0; i < selects.length; i++) {
        var options = $(selects[i]).find('option');

        for (var n = 0; n < options.length; n++) {
          var option = $(options[n]),
              value = option.attr('value');

          if (value == '' || value == '0') {
            option.prop('selected', true);
          }
        }
      }

      if (formName == 'models') {
        // removes all material rows except the first one
        var materials = materialsContainer.children('.form-row');
        for (var i = 1; i < materials.length; i++) {
          var materialRow = $(materials[i]);
          materialRow.remove();
        }
      } else if (formName == 'selling-form') {
        $('#amount_check').prop('checked', false).change();
        document.querySelector('.discount--label-holder').innerHTML = '';
        $self.checkSellingFormType(false);
      }

      // Reset all Select2 selectors
      $('select:not(.not-clear)').val('').trigger('change');

      stoneRowsContainer.empty();

      // Clear images area and reset input[type=file] for the images
      form.find('.drop-area-input').val('');
      imagesContainer.empty();

      if (form.find('.summernote').length > 0) {
        var noteEditors = form.find('.note-editable');
        noteEditors.html('<p><br></p>');
      }

      if (formType == 'partner-sell') {
        $('#partner-shopping-table tbody').html('');
        $('#shopping-table tbody').html('');
        $('.partner-information').html('');
      } else if (formType == 'sell') {
        $('#shopping-table tbody').html('');
      }

    }

    this.sendFormRequest = function(form, ajaxRequestUrl, formType, data) {
      $.ajax({
        method: 'POST',
        url: ajaxRequestUrl,
        dataType: 'json',
        data: data,
        success: function(response) {
          if (formType == 'add') {
            $self.appendResponseToTable(response, form);
            $('form').find('table tbody').empty();
          } else if (formType == 'edit') {
            $self.replaceResponseRowToTheTable(form, response);
          }
          $self.formSuccessHandler(form, formType);
        },
        error: function(error) {
          $self.formsErrorHandler(error, form);
        },
        complete: function() {
          // scroll to top of form window
          form[0].scrollIntoView();
          // re-enable submit buttons
          form.find('[type="submit"]').prop('disabled', false);
        }
      });
    }

    // FUNCTION THAT READS ALL THE ERRORS RETURNED FROM THE REQUEST AND APPEND THEM IN THE MODAL-FORM-BODY

    this.formsErrorHandler = function(err, form) {
      var errorMessagesHolder = $('<div class="error--messages_holder"></div>'),
          errorObject;
          
      if (form.find('[data-repair-scan]').length > 0) {
        errorObject = err.errors;
      } else if (err.statusText == 'timeout') {
        errorObject = {
          error: err
        };
      } else {
        errorObject = err.responseJSON.errors;
      }

      for (var key in errorObject) {
        var messageError = $('<div class="alert alert-danger"></div>');

        if (form.find('[data-repair-scan]').length > 0) {
          for (var x in errorObject[key]) {
            messageError.append(errorObject[key][x][0]);
          }
        } else if (errorObject[key].statusText == 'timeout') {
          messageError.append('Времето за изчакване изтече.')
        } else {
          messageError.append(errorObject[key][0]);
        }

        errorMessagesHolder.append(messageError);
      }
      form.find('.error--messages_holder').remove();
      form.find('.modal-body .info-cont').append(errorMessagesHolder);
    }

    // FUNCTION FOR ADDING THE RESPONSE ROW (RETURNED AS HTML) TO THE TABLE

    this.appendResponseToTable = function(response, form) {
      var responseHTML = response.success,
          table;

      if (response.place == 'active') {
        table = form.parents('.main-content').find('table.active tbody');
      } else if (response.place == 'inactive') {
        table = form.parents('.main-content').find('table.inactive tbody');
      } else if (response.type == 'buy') {
        table = form.parents('.main-content').find('table#buy tbody');
      } else if (response.type == 'sell') {
        table = form.parents('.main-content').find('table#sell tbody');
      } else {
        table = form.parents('.main-content').find('table tbody:not(form table tbody)');
      }

      table.append(responseHTML);

      var $openFormTriggers = table.find('[data-form]'),
          $deleteRowTiggers = table.find('.delete-btn'),
          $printTriggers = table.find('.print-btn'),
          newRowFormTrigger = $($openFormTriggers[$openFormTriggers.length - 1]),
          newDeleteRowTrigger = $($deleteRowTiggers[$deleteRowTiggers.length - 1]),
          newPrintTrigger = $($printTriggers[$printTriggers.length - 1]);

      $self.openForm(newRowFormTrigger);
      $self.deleteRow(newDeleteRowTrigger);
      $self.print(newPrintTrigger);
    }

    // FUNCTION THAT APPENDS SUCCESS MESSAGES TO THE FORM WHEN THE REQUEST IS SUCCESS

    this.formSuccessHandler = function(form, formType, resp) {
      if ($('.error--messages_holder').length) {
        $('.error--messages_holder').remove();
      }

      var text;
      if (formType == 'add') {
        text = 'Добавихте успешно записа!';
        $self.clearForm(form);
      } else if (formType == 'edit') {
        text = 'Редактирахте успешно записа!';
        if (form.find('.drop-area-gallery').length) {
          // Move the uploaded images to the product area
          var newImages = form.find('.drop-area-gallery .image-wrapper');
          form.find('.uploaded-images-area').append(newImages);
          
          // Clear images area and reset input[type=file] for the images
          form.find('.drop-area-input').val('');
          form.find('.drop-area-gallery').empty();
        }
      } else if (formType == 'sell' || formType == 'partner-sell') {
        text = 'Извършихте успешно плащане!';
        $self.clearForm(form, formType);
        $self.clearForm($('#selling-form'));
      } else if (formType == 'images') {
        text = resp.success;
      } else if (formType == 'dailyReport') {
        message = resp.success;
      }

      var successMessage = '<div class="alert alert-success">' + text + '</div>';
      form.find('.modal-body .info-cont').append(successMessage);

      setTimeout(function() {
        form.find('.modal-body .info-cont .alert-success').remove();
      }, 2000); // How long te message will be shown on the screen

    }

    // APPENDING EDIT FORM TO THE MODAL

    this.appendingEditFormToTheModal = function(currentButton, data) {
      if (currentButton[0].hasAttribute('data-repair-scan')) {
        currentButton.val('');
        $self.closeModal(currentButton.closest('.modal'));
        $('.edit--modal_holder .modal-content').html(data);
        $self.openModal($('.edit--modal_holder'));
      } else {
        var ajaxRequestLink = $self.buildAjaxRequestLink('requestForm', currentButton.attr('data-url'));
        $.ajax({
          url: ajaxRequestLink,
          success: function(response) {
            var modal = currentButton.parents().find('.edit--modal_holder .modal-content');
            modal.html(response);

            var selects = $('form[data-type="edit"] select');
            $self.initializeSelect(selects);

            if (modal.find('[data-calculatePrice-material]').length > 0 && modal.closest('#editProduct').length > 0) {
              for (var i = 0; i < modal.find('[data-calculatePrice-material]').length; i++) {
                var _this = $(modal.find('[data-calculatePrice-material]')[i]),
                    form = _this.closest('form');

                $self.materialPricesRequestBuilder(form, _this);
              }
            }

            if (modal.find('.summernote').length > 0) {
              modal.find('.summernote').summernote({
                height: 300,
                popover: {
                  image: [],
                  link: [],
                  air: []
                }
              });
            }
          }
        });
      }
    }

    // FUNCTION FOR REPLACING THE TR ROW IN THE TABLE ( THAT"s FOR THE EDIT )

    this.replaceResponseRowToTheTable = function(form, response) {
      var replaceRowHTML = response.table,
          rowId = response.ID,
          rowToChange = form.parents('.main-content').find('table tbody tr[data-id="' + rowId + '"]'),
          iscurrentlyActive = rowToChange.closest('table').hasClass('active'),
          isCurrentlyBuy = rowToChange.closest('table').hasClass('buy');

      if (response.place == 'active' && !iscurrentlyActive) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table.active tbody'), replaceRowHTML);
      } else if (response.place == 'inactive' && iscurrentlyActive) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table.inactive tbody'), replaceRowHTML);
      } else if (response.type == 'buy' && !isCurrentlyBuy) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table#buy tbody'), replaceRowHTML);
      } else if (response.type == 'sell' && isCurrentlyBuy) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table#sell tbody'), replaceRowHTML)
      } else {
        rowToChange.replaceWith(replaceRowHTML);
      }

      var editBtn = form.parents('.main-content').find('table tbody tr[data-id="' + rowId + '"] .edit-btn'),
          deleteBtn = form.parents('.main-content').find('table tbody tr[data-id="' + rowId + '"] .delete-btn'),
          printBtn = form.parents('.main-content').find('table tbody tr[data-id="' + rowId + '"] .print-btn'),
          returnRepairBtn = form.parents('.main-content').find('table tbody tr[data-id="' + rowId + '"] [data-repair-return]');

      $self.openForm(editBtn);
      $self.deleteRow(deleteBtn);
      $self.print(printBtn);
      $self.returnRepairBtnAction(returnRepairBtn);
    }

    // FUNCTION TO MOVE ROW FROM ONE TABLE TO ANOTHER WHEN EDITING ON SCREENS WITH MULTIPLE TABLES

    this.moveRowToTheTable = function(row, targetTable, replaceRowHTML) {
      row.remove();
      targetTable.append(replaceRowHTML);
    }

    // FUNCTION THAT DISPLAY THE EDIT SUCCESS MESSAGE.

    this.formSuccessEditMessageHandler = function(form) {
      if ($('.error--messages_holder').length) {
        $('.error--messages_holder').remove();
      }

      var successMessage = $('<div class="alert alert-success"></div>');

      successMessage.html('Редактирахте успешно записа!');
      form.find('.modal-body .info-cont').append(successMessage);

      setTimeout(function() {
        form.find('.modal-body .info-cont .alert-success').remove();
      }, 2000);
    }

    // FUNCTION THAT BUILDS THE AJAX REQUEST LINK

    this.buildAjaxRequestLink = function(type, path) {
      var prefix;

      switch (type) {
        case 'requestForm':
          prefix = '/admin/';
          break;
        case 'submitForm':
        case 'deleteRow':
        case 'print':
          prefix = '/ajax/';
          break;
      }

      return prefix + path;
    }

    this.print = function(btn) {
      btn.on('click', function(e) {
        e.preventDefault();
        var ajaxRequestLink = $self.buildAjaxRequestLink('print', $(this).attr('href'));
        $self.handlePrintResponse(ajaxRequestLink);
      });
    }

    this.handlePrintResponse = function(ajaxRequestUrl) {
      $.ajax({
        type: 'GET',
        url: ajaxRequestUrl,
        success: function(response) {
          if (response.html) {
            var toPrint = response.html,
                node = document.createElement('div'),
                printElement = document.body.appendChild(node);

            printElement.classList.add('to-print');
            printElement.innerHTML = toPrint;
            document.body.classList.add('print-mode');
            window.print();
            document.body.removeChild(node);
            document.body.classList.remove('print-mode')
          }
        }
      });
    }

    this.travellingMaterialsState = function(travelingMaterialsStateBtns) {
      travelingMaterialsStateBtns.on('click', function(e) {
        e.preventDefault();

        var _this = $(this),
            buttonState = _this.attr('data-travelstate'),
            row = _this.parents('tr[data-id]'),
            buttonStateRowId = row.attr('data-id');

        $.ajax({
          method: 'POST',
          url: '/ajax/materials/' + buttonState + '/' + buttonStateRowId,
          success: function(resp) {
            var htmlResponse = resp.success;
            row.replaceWith(htmlResponse);
          }
        });
      });
    }

    this.addMaterialsInit = function(form) {
      var addMaterialsTrigger = form.find('[data-addMaterials-add]'),
          defaultBtnsCollection = $('.default_material');

      $self.giveElementsIds(defaultBtnsCollection);

      addMaterialsTrigger.on('click', function() {
        $self.addMaterials(form);
      });
    }

    this.addMaterials = function(form) {
      var materialsWrapper = form.find('.model_materials'),
          newRow = document.createElement('div'),
          hr = '<div class="col-12"><div class="col-6"><hr></div></div>';

      $(newRow).addClass('form-row');

      newRow.innerHTML = hr + newMaterialRow;

      var select = $(newRow).find('select');
      $(newRow).find('[data-calculateprice-default]').prop('checked', false);
      
      $self.initializeSelect(select);

      materialsWrapper.append(newRow);

      var defaultBtnsCollection = $('.default_material');
      $self.giveElementsIds(defaultBtnsCollection);

      var newRemoveTrigger = $(newRow).find('[data-materials-remove]');
      $self.removeMaterialsAttach(newRemoveTrigger);

      var newCalculatePriceTrigger = $(newRow).find('[data-calculatePrice-retail], [data-calculatePrice-default]');
      $self.calculatePriceAttach(newCalculatePriceTrigger, form);

      var newPriceRequestTrigger = $(newRow).find('[data-calculatePrice-material]');
      $self.materialPricesRequestAttach(newPriceRequestTrigger, form);
    }

    this.removeMaterialsInit = function(form) {
      var removeMaterialsTrigger = form.find('[data-materials-remove]');
      $self.removeMaterialsAttach(removeMaterialsTrigger);
    }

    this.removeMaterialsAttach = function(collection) {
      collection.on('click', function() {
        $self.removeMaterials($(this));
      });
    }

    this.removeMaterials = function(_this) {
      var errorMessage = 'Материалът, който искате да премахнете е избран за материал по подразбиране и не може да бъде изтрит.',
          materialRow = _this.closest('.form-row'),
          isDefault = materialRow.find('[data-calculateprice-default]').is(':checked');

      if (isDefault) {
        alert(errorMessage);
      } else {
        materialRow.remove();
      }
    }

    this.addStonesInit = function(form) {
      var addStoneTrigger = form.find('[data-addStone-add]'),
          forFlowCollection = $('.stone-flow');

      $self.giveElementsIds(forFlowCollection);
      addStoneTrigger.on('click', function() {
        $self.addStone(form);
      });
    }

    this.addStone = function(form, stone) {
      var stonesWrapper = form.find('.model_stones'),
          fields = stonesWrapper.find('.fields'),
          maxFields = 10,
          amount = stone ? stone.amount : '',
          weight = stone ? stone.weight : '',
          flow = stone && stone.flow == 'yes' ? 'checked' : '';

      if (fields.length < maxFields) {
        var fieldsHolder = document.createElement('div');
        fieldsHolder.classList.add('form-row', 'fields');

        fieldsHolder.innerHTML = newStoneRow;

        if (stone) {
          $(fieldsHolder).find('[data-calculateStones-amount]').attr('value', amount);
          $(fieldsHolder).find('[data-calculateStones-weight]').attr('value', weight);
          $(fieldsHolder).find('.stone-flow').addClass(flow);
        }

        var select = $(fieldsHolder).find('select');
        $self.initializeSelect(select);

        stonesWrapper.append(fieldsHolder);

        var forFlowCollection = $('.stone-flow');
        $self.giveElementsIds(forFlowCollection);

        var newRemoveTrigger = $(fieldsHolder).find('[data-stone-remove]');
        $self.removeStoneAttach(newRemoveTrigger, form);

        var newCalculateTrigger = $(fieldsHolder).find('[data-calculateStones-weight], .stone-flow');
        $self.calculateStonesAttach(newCalculateTrigger, form);

        var newCalculatePriceTrigger = $(fieldsHolder).find('[data-calculateStones-weight], [data-calculatePrice-stone], [data-calculateStones-amount]');
        $self.calculatePriceAttach(newCalculatePriceTrigger, form);
      }
    }

    this.removeStoneInit = function(form) {
      var removeTrigger = form.find('[data-stone-remove]');
      $self.removeStoneAttach(removeTrigger, form);
    }

    this.removeStoneAttach = function(collection, form) {
      collection.on('click', function() {
        $self.removeStone($(this), form);
      })
    }

    this.removeStone = function(_this, form) {
      var parents = _this.closest('.form-row');
      parents.remove();
      $self.calculateStones(form);
      $self.calculatePrice(form);
    }

    this.calculateStonesInit = function(form) {
      var calculateStonesTrigger = form.find('[data-calculateStones-weight], .stone-flow');
      $self.calculateStones(form);
      $self.calculateStonesAttach(calculateStonesTrigger, form);
    }

    this.calculateStonesAttach = function(collection, form) {
      collection.on('change', function() {
        $self.calculateStones(form);
      });
    }

    this.calculateStones = function(form) {
      var stoneRows = form.find('.model_stones .fields'),
          totalNode = form.find('[data-calculateStones-total]'),
          currentTotal = 0;

      for (var i = 0; i < stoneRows.length; i++) {
        row = $(stoneRows[i]);
        var isForFlow = row.find('.stone-flow').is(':checked'),
            rowTotalNode = row.find('.row-total-weight');

        if (isForFlow) {
          var rowWeight = row.find('[data-calculateStones-weight]').val() * 1;

          rowTotalNode.html('(' + rowWeight + ' гр.)');
          rowTotalNode.css('opacity', '1');
          currentTotal += rowWeight;
        } else {
          rowTotalNode.css('opacity', '0');
        }
      }

      totalNode.val(currentTotal);
    }

    this.giveElementsIds = function(collection) {
      for (i = 0; i < collection.length; i++) {
        var element = collection[i],
            setBtnId;

        if ($(element).hasClass('default_material')) {
          setBtnId = 'material_' + String(i + 1);
        } else if ($(element).hasClass('stone-flow')) {
          setBtnId = 'stoneFlow_' + String(i + 1);
        }

        element.setAttribute('id', setBtnId);
        element.nextElementSibling.setAttribute('for', setBtnId);
      }
    }

    this.calculatePriceInit = function(form) {
      var calculatePriceTrigger = form.find('[data-calculatePrice-retail], [data-calculatePrice-default], [data-calculatePrice-netWeight], [data-calculatePrice-withStones], [data-calculateStones-weight], [data-calculatePrice-stone], [data-calculateStones-amount]');
      $self.calculatePriceAttach(calculatePriceTrigger, form);
    }

    this.calculatePriceAttach = function(collection, form) {
      collection.on('change', function() {
        $self.calculatePriceHandler(form, $(this));
      });
    }

    this.calculatePriceHandler = function(form, _this) {
      var row = _this.closest('.form-row');
      if (row.find('[data-calculatePrice-default]:checked').length > 0 || row.find('[data-calculatePrice-netWeight]').length > 0 || form.attr('name') == 'products' || _this.closest('.model_stones').length > 0) {
        $self.calculatePrice(form);
      }
    }

    this.calculatePrice = function(form) {
      var workmanshipHolder = form.find('[data-calculatePrice-worksmanship]'),
          grossWeightHolder = form.find('[data-calculatePrice-grossWeight]'),
          stones = form.find('.model_stones .fields'),
          finalHolder = form.find('[data-calculatePrice-final]'),
          defaultMaterialRow = form.find('[data-calculatePrice-default]:checked').closest('.form-row'),
          sellPrice = form.attr('name') == 'products' ? form.find('[data-calculatePrice-retail] :selected').attr('data-price') * 1 : defaultMaterialRow.find('[data-calculatePrice-retail] :selected').attr('data-price') * 1,
          buyPrice = form.attr('name') == 'products' ? form.find('[data-calculatePrice-material] :selected').attr('data-pricebuy') * 1 : defaultMaterialRow.find('[data-calculatePrice-material] :selected').attr('data-pricebuy') * 1,
          netWeight = form.find('[data-calculatePrice-netWeight]').val() * 1,
          grossWeight = 0,
          isWeightWithStones = $('[data-calculatePrice-withStones]').is(':checked'),
          naturalStonesPrice = 0,
          synthStonesWeight = 0;

      for (var i = 0; i < stones.length; i++) {
        var stoneRow = $(stones[i]),
            stone = stoneRow.find('[data-calculatePrice-stone] option:selected'),
            stonePrice = stone.attr('data-stone-price') * 1,
            stoneType = stone.attr('data-stone-type'),
            stoneWeight = stoneRow.find('[data-calculateStones-weight]').val() * 1,
            stonesAmount = stoneRow.find('[data-calculateStones-amount]').val() * 1;

        if (stoneType == 2) { // natural stone
          naturalStonesPrice += (stonePrice * stonesAmount);
        } else if (stoneType == 1) { // synthetic stone
          synthStonesWeight += stoneWeight;
        }
      }

      if (isWeightWithStones) {
        grossWeight = netWeight + synthStonesWeight;
      } else {
        grossWeight = netWeight;
      }

      grossWeightHolder.val(grossWeight);

      if (sellPrice && buyPrice && netWeight) {
        if (!isWeightWithStones) {
          var worksmanShipPrice = parseFloat(((sellPrice - buyPrice) * netWeight).toFixed(2)),
            productPrice = parseFloat(((sellPrice * netWeight) + naturalStonesPrice).toFixed(2));
        } else if (isWeightWithStones) {
          var worksmanShipPrice = parseFloat(((sellPrice - buyPrice) * grossWeight).toFixed(2)),
            productPrice = parseFloat(((sellPrice * grossWeight) + naturalStonesPrice).toFixed(2));
        }

        workmanshipHolder.val(worksmanShipPrice);
        finalHolder.val(productPrice);
      }
    }

    this.materialPricesRequestInit = function(form) {
      var pricesRequestTrigger = form.find('[data-calculatePrice-material]');
      $self.materialPricesRequestAttach(pricesRequestTrigger, form);
    }

    this.materialPricesRequestAttach = function(collection, form) {
      collection.on('change', function() {
        $self.materialPricesRequestBuilder(form, $(this));
      });
    }

    this.materialPricesRequestBuilder = function(form, _this) {
      var ajaxUrl = window.location.origin + '/ajax/getPrices/',
          materialType = _this.find(':selected').val(),
          materialAttribute = _this.find(':selected').attr('data-material'),
          pricesFilled = _this.closest('.form-row').find('.prices-filled'),
          requestLink = ajaxUrl + materialAttribute,
          formName = form.attr('name');

      if (materialType == 0) {
        pricesFilled.val('0');
        pricesFilled.attr('disabled', true);

        if (formName == 'products' || _this.closest('.form-row').find('[data-calculatePrice-default]').is(':checked')) {
          form.find('[data-calculatePrice-worksmanship]').val(0);
          form.find('[data-calculatePrice-final]').val(0);
        }

        return;
      }

      if (formName == 'products') {
        var modelId = form.find('[data-calculatePrice-model] option:selected').val();
        requestLink += '/' + modelId;
      } else if (formName == 'orders') {
        var modelId = form.find('[data-calculateprice-model] option:selected').val();
        requestLink += '/' + modelId;
      } else {
        requestLink += '/0';
      }

      if (materialAttribute !== undefined) {
        $self.ajaxFn('GET', requestLink, $self.materialPricesResponseHandler, '', form, _this);
      }
    }

    this.materialPricesResponseHandler = function(response, form, _this) {
      var retailPrices = response.retail_prices,
          retaiPriceFilled = _this.closest('.form-row').find('[data-calculatePrice-retail]');

      $self.fillPrices(retaiPriceFilled, retailPrices, form);
    }

    this.fillPrices = function(element, prices, form) {
      //  for now it's made for classic select, needs review when we apply Select2
      element.html('<option value="">Избери</option>');
      element.attr('disabled', false);

      prices.forEach(function(price) {
        var selected = price.selected ? 'selected' : '';
        var option = '<option value="' +
            price.id + '" data-material="' +
            price.material + '" data-price="' +
            price.price + '" ' +
            selected + '>' +
            price.slug + '</option>';

        element.append(option);
      });

      $self.calculatePrice(form);
    }

    this.productsModelSelectCallback = function(event, selectElement, form) {
      var modelId = selectElement.val(),
          ajax = window.location.origin + '/' + selectElement[0].dataset.url,
          ajaxUrl = ajax + modelId;

      $self.ajaxFn('GET', ajaxUrl, $self.modelRequestResponseHandler, '', form);
    }

    this.modelRequestResponseHandler = function(response, form) {
      /* Form specific properties */
      if (form[0].name == 'products') {
        $self.fillPhotos(response.photos, form);
      }

      if ($('[data-calculatePrice-withStones]').is(':checked')) {
        $self.calculatePrice(form);
      }

      $self.fillMaterials(response.materials, form);
      $self.fillJewel(response.jewels_types, form);
      $self.fillStones(response.stones, form);
      $self.fillSize(response.size, form);
      $self.fillWeight(response, form);
      $self.fillFinalPrice(response.price, form);
      $self.fillWorkmanshipPrice(response.workmanship, form);
      $self.calculateStones(form);
    }

    this.selectModel = function(model, form) {
      var select = form.find('[data-calculateprice-model]'),
          selected = model.value;
      
      if (select.find('[value="' + selected + '"]').length) {
        select.val(selected).trigger('change');
      } else {
        var option = '<option value="' +
            model.value + '" data-model-id="' +
            model.id + '" data-jewel="' +
            model.jewel + '" ' +
            'selected' + '>' +
            model.label + '</option>';
        
        select.append(option);    
      }
    }
    
    this.fillMaterials = function(materials, form) {
      var materialHolder = form.find('[data-calculatePrice-material]');
      materialHolder.html('<option value="">Избери</option>');

      materials.forEach(function(material) {
        var selected = material.selected ? 'selected' : '';
        var option = '<option value="' +
            material.value + '" data-material="' +
            material.dataMaterial + '" data-pricebuy="' +
            material.priceBuy + '" ' +
            selected + '>' +
            material.label + '</option>';

        materialHolder.append(option);
        materialHolder.attr('disabled', false);
      });

      $self.materialPricesRequestBuilder(form, materialHolder);
    }

    this.fillJewel = function(jewelsTypes, form) {
      var $jewelSelect = form.find('[data-modelFilled-jewel]'),
          selected;

      jewelsTypes.forEach(function(jewel) {
        if (jewel.selected) {
          selected = jewel.value;
        }
      });

      $jewelSelect.val(selected);
      $jewelSelect.trigger('change');
      $jewelSelect.attr('disabled', false);
    }

    this.fillStones = function(stones, form) {
      var stonesHolder = form.find('.model_stones');

      stonesHolder.empty();
      if (stones.length) {
        stones.forEach(function(stone) {
          $self.addStone(form, stone);
        });
      }
    }

    this.fillWeight = function(response, form) {
      var netWeightHolder = form.find('[data-calculatePrice-netWeight]'),
          grossWeightHolder = form.find('[data-calculatePrice-grossWeight]'),
          weight = response.weight * 1,
          isWeightWithStones = $('[data-calculatePrice-withStones]').is(':checked'),
          stones = form.find('.model_stones .fields');

      netWeightHolder.val(weight);

      if (isWeightWithStones) {
        for (var i = 0; i < stones.length; i++) {
          var stoneRow = $(stones[i]),
              stone = stoneRow.find('[data-calculatePrice-stone] option:selected'),
              stoneType = stone.attr('data-stone-type'),
              stoneWeight = stoneRow.find('[data-calculateStones-weight]').val() * 1;

          if (stoneType == 1) { // synthetic stone
            weight += stoneWeight;
          }
        }
      }

      grossWeightHolder.val(weight);
    }

    this.fillSize = function(size, form) {
      var sizeHolder = form.find('[data-modelFilld-size]');
      sizeHolder.val(size);
    }

    this.fillFinalPrice = function(price, form) {
      var finalHolder = form.find('[data-calculatePrice-final]');
      finalHolder.val(price);
    }

    this.fillWorkmanshipPrice = function(workmanshipPrice, form) {
      var workmanshipHolder = form.find('[data-calculatePrice-worksmanship]');
      workmanshipHolder.val(workmanshipPrice);
    }

    this.fillPhotos = function(photos, form) {
      var dropAreaGalleryHolder = form.find('.drop-area-gallery');

      dropAreaGalleryHolder.empty();

      photos.forEach(function(photo) {
        var imageWrapper = $(document.createElement('div')),
            newImg = $(document.createElement('img')),
            photoUrl = photo.base64,
            closeBtn = $(document.createElement('div'));

        imageWrapper.addClass('image-wrapper');
        newImg.attr('src', photoUrl);
        closeBtn.addClass('close');
        closeBtn.html('x');

        imageWrapper.append(closeBtn);
        imageWrapper.append(newImg);
        dropAreaGalleryHolder.append(imageWrapper);

        $self.deleteImagesDropArea(closeBtn);
      });
    }

    this.getWantedSumInit = function(form) {
      $self.getWantedSum(form);
      var getWantedTrigger = $('[data-selling-payment]');
      getWantedTrigger.on('click', function() {
        $self.getWantedSum(form);
      });
    }

    this.paymentInitializer = function(form) {
      var calculateTrigger = form.find('[data-calculatePayment-given]'),
          currencyChangeTrigger = form.find('[data-calculatePayment-currency]'),
          methodChangeTrigger = form.find('[data-calculatePayment-method]'),
          exchangeTrigger = form.find('[data-exchange-trigger]'),
          newExchangeFieldTrigger = form.find('[data-newExchangeField-trigger]'),
          exchangeRow = form.find('#exchange-row');

      $('#paymentModal').on('click', $self.closePayments);

      exchangeTrigger.on('change', function() {
        if (!this.checked) {
          $self.hideExchangeRow();
        } else {
          $self.showExchangeRow(exchangeRow, newExchangeField, true);
        }
      });

      newExchangeFieldTrigger.on('click', function() {
        $self.addNewExchangeField(newExchangeField, true);
      });

      exchangeRow.on('click', '[data-exchangeRowRemove-trigger]', $self.removeSingleExchangeRow);

      exchangeRow.on('change', '[data-calculateprice-material]', function() {
        $self.exchangeMaterialCaratConvert($(this).closest('.form-row'));
      });

      exchangeRow.on('change', '[data-weight]', $self.setExchangeMaterialWeight);

      exchangeRow.on('change', '[name="calculating_price"]', function() {
        $self.calculateExchangeMaterialTotal();
      });

      calculateTrigger.on('change', function() {
        $self.calculatePaymentInit(form);
      });

      currencyChangeTrigger.on('change', function() {
        $self.paymentCurrencyChange(form);
      });

      methodChangeTrigger.on('change', function() {
        $self.paymentMethodChange(form, $(this));
      });
    }

    this.hideExchangeRow = function() {
      var row = $('#exchange-row');

      row.animate({
        opacity: 0,
      }, 300, function() {
        row.css('display', 'none');

        $self.removeExchangeRows();
        document.querySelector('#exchange').checked = false;
        $self.calculatePaymentInit($('[name="selling"]'));
      });
    }

    this.lockPaymentControllers = function() {
      var calculationType = document.querySelector('#shopping-table tbody').children.length > 0 ? 'for_exchange' : 'for_buy',
          paymentGiven = document.querySelector('[data-calculatepayment-given]');

      if (calculationType == 'for_buy') {
        paymentGiven.disabled = true;
      } else {
        paymentGiven.disabled = false;
      }

      paymentGiven.value = 0;
    }

    this.showExchangeRow = function(row, field, populate) {
      row.css('display', 'block');

      row.animate({
        opacity: 1,
      }, 300, function() {
        if (populate) {
          $self.addNewExchangeField(field, populate);
        }
      });
    }

    this.removeExchangeRows = function() {
      var exchangeRows = document.querySelectorAll('.exchange-row-fields .form-row');

      for (var i = 0; i < exchangeRows.length; i++) {
        exchangeRows[i].remove();
      }

      document.querySelector('[data-exchangerows-total]').value = 0;
    }

    this.removeSingleExchangeRow = function() {
      $(this).parent().parent().remove();

      if ($('.exchange-row-fields .form-row').length == 0) {
        $self.hideExchangeRow();
      }

      $self.calculateExchangeMaterialTotal();
    }

    this.addNewExchangeField = function(field, populate) {
      var populateType = document.querySelector('#shopping-table tbody').children.length > 0 ? 'for_exchange' : 'for_buy';

      document.querySelector('.exchange-row-fields').insertAdjacentHTML('beforeend', field);

      if (populate) {
        $self.populateExchangeMaterials(populateType);
      }
    }

    this.populateExchangeMaterials = function(type) {
      var materials = document.querySelectorAll('[data-calculateprice-material]'),
          materialHolder = materials[materials.length - 1],
          materialsData = $('#materials_data').length > 0 ? JSON.parse($('#materials_data').html()) : null;

      for (var i = 0; i < materialsData.length; i++) {
        if (materialsData[i][type] == 'yes') {
          $self.addExchangeMaterial(materialsData[i], materialHolder, false);
        }
      }

      $self.initializeSelect($(materialHolder));

      //TODO - CHECK THIS AFTER SELECT 2 IMPLEMENTATION
    }

    this.addExchangeMaterial = function(material, materialHolder, select) {
      var option = document.createElement("option");

      option.text = material.label;
      option.dataset.pricebuy = material.price;
      option.dataset.carat = material.carat;
      option.dataset.transform = material.carat_transform;
      option.value = material.value;

      materialHolder.add(option);

      if (select) {
        option.selected = true;
      }
    }

    this.closePayments = function(e) {
      if (e.target.id == 'paymentModal' || e.target.parentElement.classList.contains('close')) {
        $self.hideExchangeRow();
        document.querySelector('[data-calculatepayment-return]').value = '';
        document.querySelector('[data-calculatepayment-given]').value = 0;
      }
    }

    this.setExchangeMaterialWeight = function() {
      var $this = $(this),
          weight = $this.val().replace(/^0+/, '');

      $this.val(weight);
      $this.attr('value', weight);

      $self.exchangeMaterialCaratConvert($this.closest('.form-row'));
    }

    this.exchangeMaterialCaratConvert = function(row) {
      var transform = row.find('[data-calculateprice-material] :selected').attr('data-transform'),
          weight = row.find('[data-weight]'),
          materialPrice = row.find('[data-calculateprice-material] :selected'),
          carat,
          convertedWeight = 0;

      if (materialPrice.val() > 0 && weight.val() > 0) {
        if (transform == 'yes') {
          carat = parseFloat(materialPrice.attr('data-carat'));
          convertedWeight = Number(((carat / 14) * weight.val()).toFixed(2));
        } else {
          convertedWeight = parseFloat(weight.val());
        }

        weight.attr('data-weight', convertedWeight);
      } else {
        weight.attr('data-weight', convertedWeight);
      }

      $self.calculateExchangeMaterialTotal();
    }

    this.calculateExchangeMaterialTotal = function() {
      var calculationType = document.querySelector('#shopping-table tbody').children.length > 0 ? 'for_exchange' : 'for_buy',
          materials = document.querySelectorAll('.exchange-row-fields .form-row'),
          expectedMaterial = parseFloat(document.querySelector('[data-expected-material]').dataset.expectedMaterial),
          weightConverted = 0,
          weightNotConvertedSum = 0,
          aboveExpected = 0,
          defaultPrice = parseFloat(document.querySelector('[data-defaultprice]').dataset.defaultprice),
          selectedPrice = parseFloat(document.querySelector('[name="calculating_price"]').selectedOptions[0].dataset.price) || defaultPrice,
          selectedCurrency = parseFloat(document.querySelector('[data-calculatepayment-currency]').selectedOptions[0].dataset.currency),
          total = 0,
          notConvertedPrice,
          notConvertedWeight;

      for (var i = 0; i < materials.length; i++) {

        if (materials[i].closest('.form-row').querySelector('[data-calculateprice-material]').selectedOptions[0].dataset.transform == 'yes') {
          weightConverted += parseFloat(materials[i].querySelector('[data-weight]').dataset.weight) || 0;
        } else {
          notConvertedPrice = parseFloat(materials[i].querySelector('[data-calculateprice-material]').selectedOptions[0].dataset.pricebuy);
          notConvertedWeight = parseFloat(materials[i].querySelector('[data-weight]').dataset.weight);

          weightNotConvertedSum += notConvertedPrice * notConvertedWeight;
        }
      }

      if (weightConverted > expectedMaterial && calculationType == 'for_exchange') {
        aboveExpected = weightConverted - expectedMaterial;
        total = (((weightConverted - aboveExpected) * defaultPrice) + (aboveExpected * selectedPrice)) * selectedCurrency;
      } else {
        total = (weightConverted * selectedPrice) * selectedCurrency;
      }

      total += weightNotConvertedSum * selectedCurrency;
      document.querySelector('[data-exchangerows-total]').value = Number(total.toFixed(2)) || 0;

      return $self.calculatePaymentInit($('[name="selling"]'));
    }

    this.getWantedSum = function(form) {
      var wantedHolder = form.find('[data-calculatePayment-wanted]'),
          wantedValue = $('[data-calculatePayment-total]').val(),
          selectedCurrency = form.find('[data-calculatePayment-currency] :selected').attr('data-currency');

      var newWanted = Number((wantedValue * selectedCurrency).toFixed(2));
      wantedHolder.val(newWanted || 0);

      setTimeout(function() {
        if ($('#exchange').prop('checked')) {
          $self.calculateExchangeMaterialTotal();
        }
      }, 100);
    }

    this.calculatePaymentInit = function(form) {
      var givenSum = parseFloat(form.find('[data-calculatePayment-given]').val()) || 0,
          wantedSum = parseFloat(form.find('[data-calculatePayment-wanted]').val()),
          exchangeSum = parseFloat($('[data-exchangerows-total]').val()) || 0;

      $self.calculatePayment(form, givenSum, wantedSum, exchangeSum);
    }

    this.calculatePayment = function(form, givenSum, wantedSum, exchangeSum) {
      var returnHolder = form.find('[data-calculatePayment-return]'),
          returnSum;

      if (wantedSum > 0) {
        returnSum = Number((givenSum + exchangeSum - wantedSum).toFixed(2));
      } else {
        returnSum = Number(exchangeSum.toFixed(2));
      }

      returnHolder.val(returnSum);
    }

    this.paymentCurrencyChange = function(form) {
      $self.getWantedSum(form);

      if (document.querySelectorAll('.exchange-row-fields .form-row').length > 0) {
        $self.calculateExchangeMaterialTotal();
      } else {
        $self.calculatePaymentInit(form);
      }
    }

    this.paymentMethodChange = function(form, _this) {
      var currencySelector = form.find('[data-calculatePayment-currency]'),
          givenHolder = form.find('[data-calculatePayment-given]'),
          returnHolder = form.find('[data-calculatePayment-return]');

      if (_this.is(':checked')) {
        $self.paymentPOS(form, currencySelector, givenHolder, returnHolder);
      } else {
        $self.paymentCash(form, currencySelector, givenHolder, returnHolder);
      }
    }

    this.paymentPOS = function(form, currencySelector, givenHolder, returnHolder) {
      var defaultCurrrency = currencySelector.find('[data-default="yes"]').val(),
          disable = document.createAttribute('readonly');

      givenHolder[0].setAttributeNode(disable);
      currencySelector.attr('disabled', true);
      currencySelector.val(defaultCurrrency);
      $self.getWantedSum(form);

      var wantedSum = form.find('[data-calculatePayment-wanted]').val();
      givenHolder.val(wantedSum);

      $self.calculatePaymentInit(form);
    }

    this.paymentCash = function(form, currencySelector, givenHolder, returnHolder) {
      givenHolder[0].removeAttribute('readonly');
      givenHolder.val('');
      returnHolder.val('')
      currencySelector[0].removeAttribute('disabled');
    }

    this.calculateCaratsInitializer = function(form) {
      var calculateCaratTrigger = form.find('[data-calculateCarats-weight], [data-calculateCarats-type]');
      calculateCaratTrigger.on('change', function() {
        $self.calculateCarats(form)
      });
    }

    this.calculateCarats = function(form) {
      var type = form.find('[data-calculateCarats-type]').val(),
          caratHolder = form.find('[data-calculateCarats-carat]');

      if (type == '2') {
        var weight = form.find('[data-calculateCarats-weight]').val(),
            carat = weight * 5;

        caratHolder.val(carat);
      } else {
        caratHolder.val('0');
      }
    }

    this.imageHandling = function(form) {
      var uploadImagesTrigger = form.find('.drop-area-input'),
          dropArea = form.find('.drop-area'),
          deleteImagesTriggerDropArea = form.find('.drop-area-gallery .close'),
          deleteImagesTriggerUploadArea = form.find('.uploaded-images-area .close');

      uploadImagesTrigger.on('change', function(event) {
        $self.uploadImages(event, form);
      });

      $self.dragNdropImages(dropArea, form);
      $self.deleteImagesDropArea(deleteImagesTriggerDropArea);
      $self.deleteImagesUploadArea(deleteImagesTriggerUploadArea, form);
    }

    this.manualReceipt = function(form) {
      var btnManualReceipt = form.find('[data-manual-receipt]');
      btnManualReceipt.on('click', function() {
        event.preventDefault();
        var manualReceipt = form.find('');
      });
    }

    this.barcodeInput = function(form) {
      var barcodeInput = form.find('#calculate_product');
      barcodeInput.on('input', function(event) {
        if (event.currentTarget.value.length >= 13) {
          // TODO possible bug with window.location.origin, to be tested with different url-s
          var urlOrigin = window.location.origin,
              inputUrl = event.currentTarget.dataset.url,
              inputValue = event.currentTarget.value;

          var ajaxUrl = urlOrigin + '/' + inputUrl + inputValue;
          $self.ajaxFn('GET', ajaxUrl, $self.barcodeResponseHandler, '', form);
        }
      })
    }

    this.barcodeResponseHandler = function(response, form) {
      $self.selectModel(response.models[0], form);
      $self.modelRequestResponseHandler(response, form);
    }

    this.onOrdersFormSelectCallback = function(event, selectElement, form) {
      var ajax = selectElement[0].dataset.url,
          selectedModelId = selectElement[0].selectedOptions[0].value,
          ajaxUrl = window.location.origin + '/' + ajax + selectedModelId;

      $self.ajaxFn('GET', ajaxUrl, $self.modelRequestResponseHandler, '', form);
    }

    this.addAnother = function(form) {
      var addAnother = form.find('#btnAddAnother');

      addAnother.on('click', function(event) {
        event.preventDefault();

        var container = form.find('.given-material'),
            newRow = $(givenMaterialRow);
        
        var newRemoveTrigger = newRow.find('[data-materials-remove]');
        $self.removeMaterialsAttach(newRemoveTrigger);

        var select = newRow.find('select');
        $self.initializeSelect(select);

        container.append(newRow)
      });
    }

    this.dragNdropImages = function(dropArea, form) {
      $('html').on('dragover', function(event) {
        event.preventDefault();
      });

      $('html').on('drop', function(event) {
        event.preventDefault();
      });

      dropArea.on('dragenter', function(event) {
        event.preventDefault();
        var _this = $(event.currentTarget);
        _this.addClass('dragging');
        _this.children().css('pointer-events', 'none');
      });

      dropArea.on('dragleave', function(event) {
        event.preventDefault();
        var _this = $(event.currentTarget);
        _this.removeClass('dragging');
        _this.children().css('pointer-events', 'auto');
      });

      dropArea.on('drop', function(event) {
        event.preventDefault();
        var _this = $(event.currentTarget),
            collectionFiles = [];

        event.dataTransfer = event.originalEvent.dataTransfer;
        _this.removeClass('dragging');
        _this.children().css('pointer-events', 'auto');

        if (event.dataTransfer.items) {
          for (var i = 0; i < event.dataTransfer.items.length; i++) {
            var item = event.dataTransfer.items[i];

            if (item.kind === 'file') {
              var file = item.getAsFile();
              if (file.type == "image/svg+xml") {
                alert('Избраният формат не се поддържа.\nФорматите които се поддържат са: jpg,jpeg,png,gif');
              } else {
                collectionFiles.push(file);
              }
            }
          }
        } else {
          for (var i = 0; i < event.dataTransfer.files.length; i++) {
            var file = event.dataTransfer.files[i];
            if (file.type == 'image/svg+xml') {
              alert('Избраният формат не се поддържа.\nФорматите които се поддържат са: jpg,jpeg,png,gif');
            } else {
              collectionFiles.push(file);
            }
          }
        }

        $self.appendImages(collectionFiles, form);
      });
    }

    this.uploadImages = function(event, form) {
      var files = event.target.files,
          collectionFiles = [];

      for (var file of files) {
        if (file.type == "image/svg+xml") {
          alert("Избраният формат не се поддържа.\nФорматите които се поддържат са: jpg,jpeg,png,gif");
        } else {
          collectionFiles.push(file);
        }
      }

      $self.appendImages(collectionFiles, form);
    }

    this.appendImages = function(collectionFiles, form) {
      var _instanceFiles = [];

      collectionFiles.forEach(function(element) {
        var reader = new FileReader();
        reader.readAsDataURL(element);
        reader.onloadend = function() {
          var imageWrapper = document.createElement('div'),
              closeBtn = document.createElement('div'),
              img = document.createElement('img');

          _instanceFiles.push(reader.result);

          imageWrapper.setAttribute("class", "image-wrapper");
          closeBtn.setAttribute("class", "close");
          closeBtn.innerHTML = '&#215;';
          $self.deleteImagesDropArea($(closeBtn));

          img.src = reader.result;
          imageWrapper.append(closeBtn);
          imageWrapper.append(img);
          form.find('.drop-area-gallery').append(imageWrapper);
        }
      });
    }

    this.deleteImagesDropArea = function(deleteBtn) {
      deleteBtn.on('click', function() {
        $(this).parent('.image-wrapper').remove();
      });
    }

    this.deleteImagesUploadArea = function(deleteBtn, form) {
      deleteBtn.on('click', function() {
        var _this = $(this),
            path = _this.find('span[data-url]').attr('data-url'),
            ajaxUrl = '/ajax/' + path;

        $.ajax({
          type: 'POST',
          url: ajaxUrl,
          success: function(resp) {
            $self.formSuccessHandler(form, 'images', resp);
            _this.closest('.image-wrapper').remove();
          }
        });
      });
    }

    this.fillRepairPrice = function(form) {
      var fillPriceTrigger = form.find('[data-repair-type]');
      fillPriceTrigger.on('change', function() {
        var price = $(this).find(':selected').attr('data-price');
        priceHolder.val(price);
      });
    }

    this.calculateRepairAfterPriceInit = function(form) {
      var calculatePriceTrigger = $('[data-repair-type], [data-repair-material], [data-repair-weightAfter]');
      calculatePriceTrigger.on('change', function() {
        $self.calculateRepairAfterPrice(form);
      });
    }

    this.calculateRepairAfterPrice = function(form) {
      if (form.attr('data-type') == 'edit') {
        var repairPrice = form.find('[data-repair-type] :selected').attr('data-price') * 1,
            materialPrice = form.find('[data-repair-material] :selected').attr('data-price') * 1,
            weightBefore = form.find('[data-repair-weightBefore]').val(),
            weightAfter = form.find('[data-repair-weightAfter]').val(),
            weightDifference = weightAfter < weightBefore ? 0 : weightAfter - weightBefore,
            priceAfter,
            priceAfetrHolder = form.find('[data-repair-priceAfter]');

        priceAfter = repairPrice + (weightDifference * materialPrice);
        priceAfter = Math.round(priceAfter * 100) / 100;
        priceAfetrHolder.val(priceAfter);
      }
    }

    this.focusDatePicker = function(form) {
      var datePickerTriggers = form.find('.timepicker-input input:not([readonly])').closest('.timepicker-input').find('.input-group-addon');
      datePickerTriggers.on('click', function() {
        var datePicker = $(this).closest('.timepicker-input').find('input');
        datePicker.focus();
      });
    }

    this.barcodeProcessRepairAttach = function(input) {
      input.on('change', function() {
        var _this = $(this),
            barcode = _this.val(),
            type = _this.attr('data-repair-scan');

        if (barcode.length > 0) {
          var urlTaken = window.location.href.split('/'),
              url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs/' + type,
              ajaxUrl = url + '/' + barcode;

          if (type == 'edit') {
            $self.ajaxFn('GET', ajaxUrl, $self.barcodeProcessEditResponse, '', '', _this);
          } else if (type == 'return') {
            $self.ajaxFn('GET', ajaxUrl, $self.barcodeProcessReturnResponse, '', '', _this);
          }
        }
      })
    }

    this.barcodeProcessEditResponse = function(data, elements, currentPressedBtn) {
      $self.openFormAction(currentPressedBtn, data);
    }

    this.barcodeProcessReturnResponse = function(data, elements, currentPressedBtn) {
      if (data.hasOwnProperty('success')) {
        window.location.replace(data.redirect);
      } else if (data.hasOwnProperty('errors')) {
        var form = currentPressedBtn.closest('form');
        $self.formsErrorHandler(data, form);
      }
    }

    this.lifetimeDiscount = function(form) {
      var lifetimeSelect = form.find('#lifetime_add');

      lifetimeSelect.on('change', function(event) {
        var isSelected = event.currentTarget.checked;
        form.find('[name="date_expires"]').attr('readonly', isSelected);
      });
    }

    this.storeSelectInit = function() {
      var storeSelect = $('.store-select');

      storeSelect.on('change', function() {
        $('#website_visible').prop('checked', false);
      });
    }

    this.returnRepairBtnAction = function(returnRepairBtn) {
      returnRepairBtn.on('click', function() {
        var urlTaken = window.location.href.split('/'),
            path = $(this).attr('data-url'),
            ajaxUrl = urlTaken[0] + '//' + urlTaken[2] + '/ajax/' + path;

        $self.ajaxFn('GET', ajaxUrl, $self.barcodeProcessReturnResponse, '', '', $(this));
      })
    }

    this.openModal = function(modal) {
      var backdrop1 = document.createElement('div'),
          backdrop2 = document.createElement('div');

      $(backdrop1).addClass('modal-backdrop fade in');
      $(backdrop2).addClass('modal-backdrop fade show');
      document.body.appendChild(backdrop1);
      document.body.appendChild(backdrop2);
      modal.addClass('show in');
      modal.css('display', 'block');
      $('body').addClass('modal-open');

      var closeModalTrigger = modal.find('[data-dismiss="modal"]');

      closeModalTrigger.on('click', function() {
        $self.closeModal(modal);
      });

      modal.on('click', function(e) {
        console.log($(e.target));
      });
    }

    this.closeModal = function(modal) {
      modal.removeClass('show in');
      modal.css('display', 'none');
      $('.modal-backdrop').remove();
      $('body').removeClass('modal-open');
    }

    this.ajaxFn = function(method, url, callback, dataSend, elements, currentPressedBtn) {
      var xhttp = new XMLHttpRequest(),
          token = $self.formsConfig.globalSettings.token;

      xhttp.open(method, url, true);
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data;
          if ($self.IsJsonString(this.responseText)) {
            data = JSON.parse(this.responseText);
          } else {
            data = this.responseText;
          }
          callback(data, elements, currentPressedBtn);
        } else if (this.readyState == 4 && this.status == 401) {
          var data = JSON.parse(this.responseText);
          callback(data, elements, currentPressedBtn);
        }
      };

      xhttp.setRequestHeader('Content-Type', 'application/json');
      xhttp.setRequestHeader('X-CSRF-TOKEN', token);

      if (method === 'GET') {
        xhttp.send();
      } else {
        xhttp.send(JSON.stringify(dataSend));
      }
    }

    this.IsJsonString = function(str) {
      try {
        JSON.parse(str);
      } catch (e) {
        return false;
      }
      return true;
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
      FUNCTION THAT GET THE SELECT OPTION'S ATTRIBUTES AND ATTACH THEM ON THE SELECT2 PLUGIN LIST ITEMS.
    */

    this.addSelect2CustomAttributes = function(data, container) {
      if (data.element) {
        $(container).attr({
          'data-price': $(data.element).attr('data-price') || 0,
          'data-pricebuy': $(data.element).attr('data-pricebuy') || 0,
          'data-retail': $(data.element).attr('data-retail') || 0,
          'data-material': $(data.element).attr('data-material') || 0,
          'data-barcode': $(data.element).attr('data-barcode') || 0,
          'data-product-id': $(data.element).attr('data-product-id') || 0
        });
      }

      return data.text;
    }

    /*
      FUNCTION THAT INITIALIZES THE SELECT 2 PLUGIN
    */

    this.initializeSelect = function(select, selectCallback) {
      if (select.length > 1) {
        for (var i = 0; i < select.length; i++) {
          loadSelect2(select[i]);
        }
      } else if (select.length == 1) {
        loadSelect2(select[0]);
      }

      function loadSelect2(sel) {
        if (sel.hasAttribute('data-search')) {
          $(sel).select2({
            ajax: {
              url: sel.dataset.search,
              type: 'GET',
              dataType: 'json',
              delay: 1000,
              data: function(params) {
                var query = {
                  byName: params.term,
                  page: params.page || 1
                }
                return query;
              },
              processResults: function(data, params) {
                var data = $.map(data, function(obj) {
                  obj.id = obj.value;
                  obj.text = obj.label;
                  return obj;
                });

                params.page = params.page || 1;
          
                return {
                  results: data,
                  pagination: {
                    more: (params.page * 30) < data.total_count
                  }
                };
              },
              cache: true
            },
            minimumInputLength: 0,
            escapeMarkup: function(markup) {
              return markup;
            },
            templateResult: $self.addSelect2CustomAttributes,
            templateSelection: $self.addSelect2CustomAttributes
          });
        } else {
          $(sel).select2({
            templateResult: $self.addSelect2CustomAttributes,
            templateSelection: $self.addSelect2CustomAttributes
          })
        }
      }

      select.on('select2:select', selectCallback);
    }

    this.productTravellingBarcodeInput = function(form) {
      $('#inputBarcodeScan').on('input', function(event) {
        var text = event.target.value;
        if (text.length >= 13) {
          var ajaxUrl = window.location.origin + '/' + this.dataset.url + text;

          $self.ajaxFn('GET', ajaxUrl, $self.productTravellingAjaxResponse);
        }
      });
    }

    this.productTravellingSelectCallback = function(event, selectElement, form) {
      var selectedOption = selectElement[0].selectedOptions[0],
          productId = selectedOption.dataset.productId;

      if (productId) {
        var match = form.find('.found-product[data-id="' + productId + '"]');

        if (match.length == 0) {
          var ajax = selectElement[0].dataset.url,
              ajaxUrl = window.location.origin + '/' + ajax + selectedOption.dataset.barcode;

          $self.ajaxFn('GET', ajaxUrl, $self.productTravellingAjaxResponse);
        }
      }
    }

    this.productTravellingAjaxResponse = function(response) {
      if (response.errors) {
        var error = response.errors.not_found[0],
            errorElement = '<div class="alert alert-danger table-alert">' + error + '</div>',
            stayingTime = 3000;

        $('.info-cont').append(errorElement);
        setTimeout(function() {
          $('.info-cont').empty();
        }, stayingTime);
      } else {
        var id = response.item.id,
            name = response.item.name,
            weight = response.item.weight,
            barcode = response.item.barcode;

        var productElement = '<tr class="found-product" data-id="' +
            id + '"><input type="hidden" name="product_id[]" value="' +
            id + '"><td>' +
            barcode + '</td><td>' +
            name + '</td><td>' +
            weight + ' гр</td><td><span data-url="#" class="delete-btn" data-parent-id="' +
            id + '"><i class="c-brown-500 ti-trash"></i></span></td></tr>';

        $('#inputBarcodeScan').val('');
        $('form').find('table tbody').append(productElement);
        $('.delete-btn[data-parent-id="' + id + '"]').on('click', function() {
          $(this).parents('.found-product').remove();
        });
      }
    }

    this.checkAllForms = function(currentPressedBtn) {
      var certificateBtns = document.querySelectorAll('.certificate');

      certificateBtns.forEach(function(btn) {
        btn.addEventListener('click', printCertificate);
      });

      function printCertificate(e) {
        var urlTaken = window.location.href.split('/'),
            url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs',
            certificateId = e.target.getAttribute('data-repair-id'),
            ajaxUrl = url + '/certificate/' + certificateId;

        ajaxFn('GET', ajaxUrl, printBtnSuccess, '', '', '');
      }
    }

    // Currently used in Admin->Models and Admin->Products pages
    this.setInputFilters = function() {
      var inputsDynamicSearch = $('.filter-input'),
          timeout;

      inputsDynamicSearch.on('input', function(event) {
        
        var ajaxResultsResponse = function(response) {
          $('tbody').html(response);
          $('tbody').removeClass('inactive');
        };

        var searchFunc = function() {
          $('tbody').addClass('inactive');

          var inputText = event.currentTarget.value.trim(),
              ajax = event.currentTarget.dataset.dynamicSearchUrl,
              ajaxUrl = window.location.origin + '/' + ajax + inputText;
  
          $self.ajaxFn('GET', ajaxUrl, ajaxResultsResponse);
        };

        if (timeout != null) {
          clearTimeout(timeout);
        }
        timeout = setTimeout(searchFunc, 1000);
      });
    }
  }

$(function() {
  if (!window.console) window.console = {};
  if (!window.console.log) window.console.log = function() {};
  if (!window.console.info) window.console.info = function() {};

  uvel = new uvelController();
  uvel.init();
});
