var uvel,
  uvelController = function () {
    var $self = this,
      $window = $(window),
      $body = $('body'),
      currentPressedBtn;

    this.formsConfig = {
      globalSettings: {
        token: $('meta[name="csrf-token"]').attr('content'),
        controllers: ['submitForm']
      },
      discounts: {
        selector: '[name="discounts"]',
        controllers: [],
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
        controllers: [],
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
      selling: {
        selector: '[name="selling"]',
        controllers: ['paymentInitializer', 'getWantedSumInit'],
        initialized: false
      },
      stones: {
        selector: '[name="stones"]',
        controllers: ['calculateCaratsInitializer', 'imageHandling'],
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
        controllers: ['addMaterialsInit', 'calculateRepairAfterPriceInit', 'addStonesInit', 'removeStoneInit', 'calculateStonesInit', 'calculatePriceInit', 'materialPricesRequestInit', 'imageHandling'],
        initialized: false
      },
      products: {
        selector: '[name="products"]',
        controllers: ['nameFieldSearch', 'addStonesInit', 'removeStoneInit', 'calculateStonesInit', 'calculatePriceInit', 'materialPricesRequestInit', 'modelRequestInit', 'imageHandling'],
        initialized: false
      },
      repairTypes: {
        selector: '[name="repairTypes"]',
        controllers: [],
        initialized: false
      },
      repairs: {
        selector: '[name="repairs"]',
        controllers: ['fillRepairPrice', 'calculateRepairAfterPriceInit', 'calculateRepairAfterPrice', 'focusDatePicker'],
        initialized: false
			},
			orders: {
				selector: '[name="orders"]',
        controllers: ['nameFieldSearch', 'addStonesInit', 'addAnother', 'manualReceipt', 'modelRequestInit', 'barcodeInput'],
        initialized: false
			},
			productsTravelling: {
				selector: '[name="productsTravelling"]',
        controllers: ['nameFieldSearch'],
        initialized: false
			}
    };

    this.init = function () {
      $self.attachInitialEvents();
      // $self.initializeSelect($('select'));
      // $self.checkAllForms();
    };

    this.attachInitialEvents = function () {
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

    this.openForm = function(openFormTrigger) {
      openFormTrigger.on('click', function() {
        $self.openFormAction($(this));
      });
    };

    this.openFormAction = function(currentPressedBtn, data) {
      var $this = currentPressedBtn,
          timeToOpenModal = 1000, //time which takes for modals to open
          openedForm = $this.attr('data-form'),
          formType = $this.attr('data-form-type'),
          formSettings = $self.formsConfig[openedForm];

      if (formType == 'edit') {
        $self.appendingEditFormToTheModal($this, data);
      }

      //TODO: ASK BOBI VVVV

      setTimeout(function() {
        if ((formType == 'add' || formType == 'sell') && !formSettings.initialized) {
          $self.initializeForm(formSettings, formType);
          formSettings.initialized = true;
        } else if (formType == 'edit') {
          $self.initializeForm(formSettings, formType);
        }
      }, timeToOpenModal);
    }

    this.enterPressBehaviour = function(inputs) {
      inputs.on('keypress', function(event) {
        if (event.which == 13) {
          var _this = $(this);
          event.preventDefault();
          _this.trigger('change');
          _this.blur();
        }
      })
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
            'catalog_number' : number,
            'quantity' : productsAmount,
            'amount_check' : moreProductsChecked,
            'type_repair' : typeRepair
          };
        } else if (_this[0].hasAttribute('data-sell-barcode') && number.length == 13) {
          dataSend = {
            'barcode' : Number(number),
            'quantity' : productsAmount,
            'amount_check' : moreProductsChecked,
            'type_repair' : typeRepair
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

      if(success) {
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

    this.sellMoreProducts = function (sellMoreProductsTrigger) {
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

		this.addDiscount = function (addDiscountTrigger) {
			addDiscountTrigger.on('click', function (e) {
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

		this.discountSuccess = function (response) {
			var discountsHolder = $('.discount--label-holder');

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
				}

				discountsHolder.html(newFields);
				$self.cartSumsPopulate(response);
				var removeDiscountTrigger = $('[data-sell-removeDiscount]');
				$self.removeDiscountAttach(removeDiscountTrigger);
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
          customControllers = formSettings.controllers;

      $self.initializeGlobalFormControllers(form);
      $self.initializeControllers(customControllers, form);
    }

    this.initializeGlobalFormControllers = function(form) {
      $self.initializeControllers($self.formsConfig.globalSettings.controllers, form);
    }

    this.initializeControllers = function(controllers, form) {
			controllers.forEach(function(controller) {
				$self[controller](form);
			});
    }

    this.submitForm = function(form) {
      var submitButton = form.find('[type="submit"]'),
				ajaxRequestLink = $self.buildAjaxRequestLink('submitForm', form.attr('action')),
				formType = form.attr('data-type');

      submitButton.click(function(e) {
        e.preventDefault();
        var inputFields = form.find('select , input, textarea');
        $self.getFormFields(form, ajaxRequestLink, formType, inputFields);
      });
    }

    this.getFormFields = function(form, ajaxRequestLink, formType, inputFields) {
      var data = {_token : $self.formsConfig.globalSettings.token},
          imageCollection = [];

      if (formType == 'edit') {
        data._method = 'PUT';
      }

      inputFields.each(function(index, element) {
        var inputType = element.type,
            dataKey = element.name,
            dataKeyValue = element.value,
            imagesInputFieldExists = dataKey == 'images' ? true : false;

        if((inputType == 'radio' || inputType == 'checkbox') && dataKey.indexOf('[]') !== -1) {
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

        if(imagesInputFieldExists) {
          var imagesHolder = $('.drop-area-gallery .image-wrapper img');

          imagesHolder.each(function(index , element) {
            var imgSource = element.getAttribute('src');
            imageCollection.push(imgSource);
          });

          data.images = imageCollection;
        }
			});

      $self.sendFormRequest(form, ajaxRequestLink, formType, data);
    }

    this.clearForm = function(form) {
			// wtf is this selector
      var textInputs = form.find('input[type="text"]:not(.not-clear), input[type="number"]:not(.not-clear), input[type="password"]:not(.not-clear), input[type="email"]:not(.not-clear), textarea:not(.not-clear)'),
          checksAndRadios = form.find('input[type="checkbox"]:not(.not-clear), input[type="radio"]:not(.not-clear)'),
          checksAndRadiosNotToClear = form.find('input[type="checkbox"].not-clear, input[type="radio"].not-clear'),
          selects = form.find('select:not(.not-clear)'),
          stoneRowsContainer = form.find('.model_stones'),
          imagesContainer = form.find('.drop-area-gallery'),
          materialsContainer = form.find('.model_materials');

      for (var i = 0; i < textInputs.length; i++) {
        var input = $(textInputs[i]);

        if (input.attr('placeholder') || input.prop('tagName') == 'TEXTAREA') {
          input.val('');
        } else {
          input.val(0);
        }
      }

      checksAndRadios.prop('checked', false);
      checksAndRadiosNotToClear.prop('checked', true);

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

      if (form.attr('name') == 'models') {
				// removes all material rows except the first one
        var materials = materialsContainer.children('.form-row');
        for (var i = 1; i < materials.length; i++) {
          var materialRow = $(materials[i]);
          materialRow.remove();
        }
      }

      stoneRowsContainer.empty();
      imagesContainer.empty();
    }

    this.sendFormRequest = function(form, ajaxRequestUrl, formType, data) {
			$.ajax({
				method: 'POST',
				url: ajaxRequestUrl,
				dataType: 'json',
				data: data,
				success: function(response) {
					// scroll to top of form window
					document.getElementsByClassName('modal-content')[0].scrollIntoView();
					if (formType == 'add') {
						$self.appendResponseToTable(response, form);
					} else if (formType == 'edit') {
						$self.replaceResponseRowToTheTable(form, response);
					}
					$self.formSuccessHandler(form, formType);
				},
				error: function(err) {
					// scroll to top of form window
					document.getElementsByClassName('modal-content')[0].scrollIntoView();
					$self.formsErrorHandler(err, form);
				}
			});
    }


    // FUNCTION THAT READS ALL THE ERRORS RETURNED FROM THE REQUEST AND APPEND THEM IN THE MODAL-FORM-BODY

    this.formsErrorHandler = function(err , form) {
        var errorObject = form.find('[data-repair-scan]').length > 0 ? err.errors : err.responseJSON.errors,
					errorMessagesHolder = $('<div class="error--messages_holder"></div>');

        for(var key in errorObject) {
          var messageError = $('<div class="alert alert-danger"></div>');

          if (form.find('[data-repair-scan]').length > 0) {
            for (var x in errorObject[key]) {
              messageError.append(errorObject[key][x][0]);
            }
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
      var responseHTML = response.success;
      var table;

      if (response.place == 'active') {
        table = form.parents('.main-content').find('table.active tbody');
      } else if(response.place == 'inactive') {
        table = form.parents('.main-content').find('table.inactive tbody');
      } else if(response.type == 'buy') {
        table = form.parents('.main-content').find('table#buy tbody');
      } else if(response.type == 'sell') {
        table = form.parents('.main-content').find('table#sell tbody');
      } else {
        table = form.parents('.main-content').find('table tbody');
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
      } else if (formType == 'edit') {
        text = 'Редактирахте успешно записа!';
      } else if (formType == 'sell') {
        text = 'Извършихте успешно плащане!';
      } else if (formType == 'images') {
        text = resp.success;
      }

      var successMessage = '<div class="alert alert-success">' + text + '</div>';
      form.find('.modal-body .info-cont').append(successMessage);

      setTimeout(function() {
        form.find('.modal-body .info-cont .alert-success').remove();
      }, 2000); // How long te message will be shown on the screen

      if (formType == 'add') {
        $self.clearForm(form);
      }
    }

    // APPENDING EDIT FORM TO THE MODAL

    this.appendingEditFormToTheModal = function(currentButton, data) {
      if (currentButton[0].hasAttribute('data-repair-scan')) {
        currentButton.val('');
        $self.closeModal(currentButton.closest('.modal'));
        $('.edit--modal_holder .modal-content').html(data);
        $self.openModal($('.edit--modal_holder'));
      }
      else {
        var ajaxRequestLink = $self.buildAjaxRequestLink('requestForm', currentButton.attr('data-url'));
        $.ajax({
          url: ajaxRequestLink,
          success: function(response) {
            var modal = currentButton.parents().find('.edit--modal_holder .modal-content');
            modal.html(response);
            // $self.initializeSelect(_this.parents().find('select'));
            if (modal.find('[data-calculatePrice-material]').length > 0 && modal.closest('#editProduct').length > 0) {
              for (var i = 0; i < modal.find('[data-calculatePrice-material]').length; i++) {
                var _this = $(modal.find('[data-calculatePrice-material]')[i]),
									form = _this.closest('form');

                $self.materialPricesRequestBuilder(form, _this);
              }
            }
          }
        });
      }
    }

    // FUNCTION FOR REPLACING THE TR ROW IN THE TABLE ( THAT"s FOR THE EDIT )

    this.replaceResponseRowToTheTable = function(form , response) {
      var replaceRowHTML = response.table,
          rowId = response.ID,
          rowToChange = form.parents('.main-content').find('table tbody tr[data-id="' + rowId + '"]'),
          iscurrentlyActive = rowToChange.closest('table').hasClass('active'),
          isCurrentlyBuy = rowToChange.closest('table').hasClass('buy');

      if (response.place == 'active' && !iscurrentlyActive) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table.active tbody'), replaceRowHTML);
      } else if(response.place == 'inactive' && iscurrentlyActive) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table.inactive tbody'), replaceRowHTML);
      } else if(response.type == 'buy' && !isCurrentlyBuy) {
        $self.moveRowToTheTable(rowToChange, form.parents('.main-content').find('table#buy tbody'), replaceRowHTML);
      } else if(response.type == 'sell' && isCurrentlyBuy) {
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
      if($('.error--messages_holder').length) {
        $('.error--messages_holder').remove();
      }

      var successMessage = $('<div class="alert alert-success"></div>');
      successMessage.html('Редактирахте успешно записа!');

      form.find('.modal-body .info-cont').append(successMessage);

      setTimeout(function() {
       form.find('.modal-body .info-cont .alert-success').remove();
      } , 2000);
    }

    // FUNCTION THAT BUILDS THE AJAX REQUEST LINK

		this.buildAjaxRequestLink = function (type, path) {
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

    this.handlePrintResponse = function(ajaxRequestLink) {
      $.ajax({
        type: 'GET',
        url : ajaxRequestLink,
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

        var buttonState = $(this).attr('data-travelstate'),
					row = $(this).parents('tr[data-id]'),
					buttonStateRowId = row.attr('data-id');

        $.ajax({
          method: 'POST',
          url: '/ajax/materials/' + buttonState + '/' + buttonStateRowId,
          success: function(response) {
            row.replaceWith(response.success);
          }
        });
      });
    }

    this.addMaterialsInit = function(form) {
      var addMaterialsTrigger = form.find('[data-addMaterials-add]');
      var defaultBtnsCollection = $('.default_material');
      $self.giveElementsIds(defaultBtnsCollection);
      addMaterialsTrigger.on('click', function() {
        $self.addMaterials(form);
      });
    }

    this.addMaterials = function(form) {
      var materialsWrapper = form.find('.model_materials');
      var materialsData = $('#materials_data').length > 0 ? JSON.parse($('#materials_data').html()) : null;
      var newRow = document.createElement('div');

      $(newRow).addClass('form-row');

      var newFields =
        '<div class="col-12">' +
        '<div class="col-6">' +
        '<hr>' +
        '</div>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        '<label>Избери материал: </label>' +
        '<select id="material_type" name="material_id[]" class="material_type form-control calculate" data-calculatePrice-material>' +
        '<option value="0">Избери</option>'

			materialsData.forEach(function (option) {
				newFields += '<option value=' +
					option.value + ' data-pricebuy=' +
					option.pricebuy + ' data-material=' +
					option.material + '>' +
					option.label + '</option>';
			});

      newFields +=
        '</select>' +
        '</div>' +
        '<div class="form-group col-md-5">' +
        '<label>Цена: </label>' +
        '<select id="retail_prices" name="retail_price_id[]" class="form-control calculate prices-filled retail-price retail_prices" data-calculatePrice-retail disabled>' +
        '<option value="0">Избери</option>' +
        '</select>' +
        '</div>' +
        '<div class="form-group col-md-1">' +
        '<span class="delete-material remove_field" data-removeMaterials-remove><i class="c-brown-500 ti-trash"></i></span>' +
        '</div>' +
        '<div class="form-group col-md-12">' +
        '<div class="radio radio-info">' +
        '<input type="radio" id="" class="default_material" name="default_material[]" data-calculatePrice-default>' +
        '<label for="">Материал по подразбиране</label>' +
        '</div>' +
        '</div>';

      newRow.innerHTML = newFields;
      materialsWrapper.append(newRow);

      var defaultBtnsCollection = $('.default_material');
      $self.giveElementsIds(defaultBtnsCollection);

      var newRemoveTrigger = $(newRow).find('[data-removeMaterials-remove]');
      $self.removeMaterialsAttach(newRemoveTrigger);

      var newCalculatePriceTrigger = $(newRow).find('[data-calculatePrice-retail], [data-calculatePrice-default]');
      $self.calculatePriceAttach(newCalculatePriceTrigger, form);

      var newPriceRequestTrigger = $(newRow).find('[data-calculatePrice-material]');
      $self.materialPricesRequestAttach(newPriceRequestTrigger, form);
    }

    this.removeMaterialsInit = function(form) {
      var removeMaterialsTrigger = form.find('[data-removeMaterials-remove]');
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

		this.addStone = function (form, stone) {
			var stonesWrapper = form.find('.model_stones'),
          fields = stonesWrapper.find('.fields'),
          stonesData = stone || $('#stones_data').length > 0 ? JSON.parse($('#stones_data').html()) : null,
          maxFields = 10,
          amount = stone ? stone.amount : '',
          weight = stone ? stone.weight : '',
          flow = stone && stone.flow == 'yes' ? 'checked' : '';

			if (fields.length < maxFields) {
				var fieldsHolder = document.createElement('div');
				fieldsHolder.classList.add('form-row', 'fields');

				var newFields = '<div class="form-group col-md-6"><label>Камък:</label>' +
					'<select name="stones[]" class="form-control" data-calculatePrice-stone>';

				for (var i = 0; i < stonesData.length; i++) {
					var option = stonesData[i],
						selected = '';

					if (stone && stone.value == option.value) {
						selected = 'selected';
					}

					newFields += '<option value=' +
						option.value + ' data-stone-price=' +
						option.price + ' data-stone-type=' +
						option.type + ' ' +
						selected + '>' +
						option.label + '</option>';
				}

				newFields +=
					'</select>' +
					'</div>' +
					'<div class="form-group col-md-4">' +
					'<label>Брой:</label>' +
					'<input type="text" value="' + amount + '" class="form-control calculate-stones" name="stone_amount[]" data-calculateStones-amount placeholder="Брой">' +
					'</div>' +
					'<div class="form-group col-md-2">' +
					'<span class="delete-stone remove_field" data-removeStone-remove><i class="c-brown-500 ti-trash"></i></span>' +
					'</div>' +
					'<div class="form-group col-md-6">' +
					'<div class="form-group">' +
					'<label>Тегло: </label>' +
					'<div class="input-group">' +
					'<input type="number" value="' + weight + '" class="form-control calculate-stones" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100">' +
					'<span class="input-group-addon">гр</span>' +
					'</div>' +
					'</div>' +
					'</div>' +
					'<div class="form-group col-md-6">' +
					'<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">' +
					'<input type="checkbox" id="" class="stone-flow calculate-stones" name="stone_flow[]" class="peer" ' + flow + '>' +
					'<label for="" class="peers peer-greed js-sb ai-c">' +
					'<span class="peer peer-greed">За леене</span>' +
					'</label>' +
					'<span class="row-total-weight"></span>' +
					'</div>' +
					'</div>';

				fieldsHolder.innerHTML = newFields;
				stonesWrapper.append(fieldsHolder);

				var forFlowCollection = $('.stone-flow');
				$self.giveElementsIds(forFlowCollection);

				var newRemoveTrigger = $(fieldsHolder).find('[data-removeStone-remove]');
				$self.removeStoneAttach(newRemoveTrigger, form);

				var newCalculateTrigger = $(fieldsHolder).find('[data-calculateStones-weight], .stone-flow');
				$self.calculateStonesAttach(newCalculateTrigger, form);

				var newCalculatePriceTrigger = $(fieldsHolder).find('[data-calculateStones-weight], [data-calculatePrice-stone], [data-calculateStones-amount]');
				$self.calculatePriceAttach(newCalculatePriceTrigger, form);
			}
		}

    this.removeStoneInit = function(form) {
      var removeTrigger = form.find('[data-removeStone-remove]');
      $self.removeStoneAttach(removeTrigger, form);
    }

    this.removeStoneAttach = function(collection, form) {
      collection.on('click', function() {
        $self.removeStone($(this), form);
      });
    }

    this.removeStone = function(_this, form) {
      _this.closest('.form-row').remove();
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

		this.calculateStones = function (form) {
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

		this.giveElementsIds = function (collection) {
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

		this.calculatePriceInit = function (form) {
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
          sellPrice = form.attr('name') == 'products' ? form.find('[data-calculatePrice-retail] :selected').attr('data-price')*1 : defaultMaterialRow.find('[data-calculatePrice-retail] :selected').attr('data-price')*1,
          buyPrice = form.attr('name') == 'products' ? form.find('[data-calculatePrice-material] :selected').attr('data-pricebuy')*1 : defaultMaterialRow.find('[data-calculatePrice-material] :selected').attr('data-pricebuy')*1,
          netWeight = form.find('[data-calculatePrice-netWeight]').val()*1,
          grossWeight = 0,
          isWeightWithStones = $('[data-calculatePrice-withStones]').is(':checked'),
          naturalStonesPrice = 0,
          synthStonesWeight = 0;

      for (var i=0; i<stones.length; i++) {
        var stoneRow = $(stones[i]),
					stone = stoneRow.find('[data-calculatePrice-stone] option:selected'),
					stonePrice = stone.attr('data-stone-price')*1,
					stoneType = stone.attr('data-stone-type'),
					stoneWeight = stoneRow.find('[data-calculateStones-weight]').val()*1,
					stonesAmount = stoneRow.find('[data-calculateStones-amount]').val()*1;

        if (stoneType == 2) {   // natural stone
          naturalStonesPrice += (stonePrice * stonesAmount);
        } else if (stoneType == 1) {  // synthetic stone
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
          var worksmanShipPrice = Math.round(((sellPrice - buyPrice) * netWeight) * 100) / 100,
						productPrice = Math.round(((sellPrice * netWeight) + naturalStonesPrice) * 100) / 100;
        } else if (isWeightWithStones) {
          var worksmanShipPrice = Math.round(((sellPrice - buyPrice) * grossWeight) * 100) / 100,
						productPrice = Math.round(((sellPrice * grossWeight) + naturalStonesPrice) * 100) / 100;
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
      collection.on('change', function(){
        $self.materialPricesRequestBuilder(form, $(this));
      });
    }

		this.materialPricesRequestBuilder = function (form, _this) {
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

		this.fillPrices = function (element, prices, form) {
			//  for now it's made for classic select, needs review when we apply Select2
			element.html('<option value="0">Избери</option>');
			element.attr('disabled', false);

			prices.forEach(function (price) {
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

    this.modelRequestInit = function(form) {
			/* Селектора (падащо меню) който ще прави рекуест */
			var modelRequestTrigger = form.find('.input-search');
      modelRequestTrigger.on('input', function() {
        var _this = $(this);
        if (_this.find('option:selected').val() !== '0' && _this.find('option:selected').val() !== '') {
          $self.modelRequest(form);
        } else {
          var collection = form.find('[data-calculatePrice-material], [data-calculatePrice-retail]');
          collection.val('0');
          collection.attr('disabled', 'disabled');
        }
      });
    }

		/* При избор на модел от падащото меню се прави тази заявка */
		this.modelRequest = function (form) {
			var inputModel = form.find('.input-search');
			var ajaxUrl = window.location.origin + '/' + inputModel.attr('data-url');
			var modelId = inputModel.attr('data-product-id');
			var requestLink = ajaxUrl + modelId;
			$self.ajaxFn('GET', requestLink, $self.modelRequestResponseHandler, '', form);
    }

		this.modelRequestResponseHandler = function (response, form) {
			/* Form specific properties */
			if (form[0].name == 'products') {
				$self.fillPhotos(response.photos, form);
			} else if (form[0].name == 'orders') {
				$self.fillModels(response.models, form);
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

		this.fillModels = function (models, form) {
			var modelElement = form.find('[data-calculateprice-model]');
			modelElement.html('<option value="0">Избери</option>');

			models.forEach(function (model) {
				var selected = model.selected ? 'selected' : '';
				var option = '<option value="' +
					model.value + '" ' +
					selected + '>' +
					model.label + '</option>';

				modelElement.append(option);
			});
		}

		this.fillMaterials = function (materials, form) {
			var materialHolder = form.find('[data-calculatePrice-material]');
			materialHolder.html('<option value="0">Избери</option>');

			materials.forEach(function (material) {
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
      var selected;
			jewelsTypes.forEach(function(jewel) {
        if (jewel.selected) {
          selected = jewel.value;
        }
      });

      form.find('[data-modelFilled-jewel]').val(selected);
    }

    this.fillStones = function(stones, form) {
      var stonesHolder = form.find('.model_stones');
      stonesHolder.empty();
      stones.forEach(function(stone) {
        $self.addStone(form, stone);
      });
    }

    this.fillWeight = function(response, form) {
			// kakvo e tva weight * 1
      var netWeightHolder = form.find('[data-calculatePrice-netWeight]'),
				grossWeightHolder = form.find('[data-calculatePrice-grossWeight]'),
				weight = response.weight * 1,
				isWeightWithStones = $('[data-calculatePrice-withStones]').is(':checked'),
				stones = form.find('.model_stones .fields');

      netWeightHolder.val(weight);

      if (isWeightWithStones) {
        for (var i=0; i<stones.length; i++) {
          var stoneRow = $(stones[i]),
						stone = stoneRow.find('[data-calculatePrice-stone] option:selected'),
						stoneType = stone.attr('data-stone-type'),
						stoneWeight = stoneRow.find('[data-calculateStones-weight]').val()*1;

          if (stoneType == 1) {  // synthetic stone
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

		this.fillPhotos = function (photos, form) {
			var dropAreaGalleryHolder = form.find('.drop-area-gallery');

			dropAreaGalleryHolder.empty();

			photos.forEach(function (photo) {
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
      })
    }

    this.paymentInitializer = function(form) {
      var calculateTrigger = form.find('[data-calculatePayment-given]'),
				currencyChangeTrigger = form.find('[data-calculatePayment-currency]'),
				methodChangeTrigger = form.find('[data-calculatePayment-method]');

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

    this.getWantedSum = function(form) {
      var wantedHolder = form.find('[data-calculatePayment-wanted]'),
				wantedValue = $('[data-calculatePayment-total]').val(),
				selectedCurrency = form.find('[data-calculatePayment-currency] :selected').attr('data-currency');

      var newWanted = Math.round((wantedValue * selectedCurrency) * 100) / 100;
      wantedHolder.val(newWanted);
    }

    this.calculatePaymentInit = function(form) {
      var givenSum = form.find('[data-calculatePayment-given]').val(),
				wantedSum = form.find('[data-calculatePayment-wanted]').val();

      $self.calculatePayment(form, givenSum, wantedSum);
    }

    this.calculatePayment = function(form, givenSum, wantedSum) {
      var returnHolder = form.find('[data-calculatePayment-return]');
      var returnSum = Math.round((givenSum - wantedSum) * 100) / 100;
      returnHolder.val(returnSum);
    }

    this.paymentCurrencyChange = function(form) {
      $self.getWantedSum(form);
      $self.calculatePaymentInit(form);
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
						inputUrl = event.currentTarget.attributes.url.value,
						inputValue = event.currentTarget.value;

					var ajaxUrl = urlOrigin + '/' + inputUrl + inputValue;
					$self.ajaxFn('GET', ajaxUrl, $self.modelRequestResponseHandler, '', form);
				}
			})
		}

		this.addAnother = function(form) {
			var addAnother = form.find('#btnAddAnother');
			addAnother.on('click', function(event) {
				event.preventDefault();
				// Copy the given materials first element
				// .outerHTML does not copy the elements values, so they are manually set
				var givenMaterialsFirstElement = $('.form-row.given-material').first()[0],
					firstMaterialId = $(givenMaterialsFirstElement).find('.mat-material').val(),
					firstMaterialQuantity = $(givenMaterialsFirstElement).find('.mat-quantity').val(),
					firstMaterialPrice = $(givenMaterialsFirstElement).find('.mat-calculated-price').val();

				var givenMaterialsNewElement = givenMaterialsFirstElement;
				// .val() does not set the inputs inner text
				$(givenMaterialsNewElement).find('.mat-material').attr('value', firstMaterialId);
				$(givenMaterialsNewElement).find('.mat-quantity').attr('value', firstMaterialQuantity);
				$(givenMaterialsNewElement).find('.mat-calculated-price').attr('value', firstMaterialPrice);

				$(givenMaterialsNewElement.outerHTML).insertBefore(this);
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

			dropArea.on('drop', function (event) {
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
        collectionFiles= [];

      for(var file of files) {
        if(file.type == "image/svg+xml") {
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
          var imageWrapper = document.createElement('div');
          var closeBtn = document.createElement('div');
          var img = document.createElement('img');

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
          var urlTaken = window.location.href.split('/');
          var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs/' + type;
          var ajaxUrl = url + '/' + barcode;

          if (type == 'edit') {
            $self.ajaxFn('GET', ajaxUrl, $self.barcodeProcessEditResponse,'','',_this);
          } else if (type == 'return') {
            $self.ajaxFn('GET', ajaxUrl, $self.barcodeProcessReturnResponse,'','',_this);
          }
        }
      })
    }

    this.barcodeProcessEditResponse = function(data, elements, currentPressedBtn) {
      $self.openFormAction(currentPressedBtn, data);
    }

    this.barcodeProcessReturnResponse = function(data, elements, currentPressedBtn) {
      if(data.hasOwnProperty('success')) {
        window.location.replace(data.redirect);
      } else if (data.hasOwnProperty('errors')) {
        var form = currentPressedBtn.closest('form');
        $self.formsErrorHandler(data, form);
      }
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
      xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
					var data;
          if($self.IsJsonString(this.responseText)){
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

      if(method === 'GET') {
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

    this.checkAllForms = function(currentPressedBtn) {
      var certificateBtns = document.querySelectorAll('.certificate');
      certificateBtns.forEach(function(btn){
        btn.addEventListener('click',printCertificate);
      });

      function printCertificate(e) {
        var urlTaken = window.location.href.split('/');
        var url = urlTaken[0] + '//' + urlTaken[2] + '/ajax' + '/repairs';
        var certificateId = e.target.getAttribute('data-repair-id');
        var ajaxUrl = url + '/certificate/' + certificateId;

        ajaxFn('GET',ajaxUrl,printBtnSuccess,'','','');
      }
		}

		// Used in Admin->Products Travelling and Admin->Products
		this.nameFieldSearch = function (form) {
			var input = $('.input-search'),
				dropdown = $(form).find('.dropdown-menu'),
				dropdownItems = $(form).find('.dropdown-item'),
				modalWindow = $('.modal-content:visible');

			input.on('focusin', function () {
				dropdown.removeClass('hidden');
			});

			modalWindow.on('click', function(event) {
				// Check if click is outside input or the dropdown menu
				// so the dropdown can be closed
				var target = event.target;
				if (!target.classList.contains('input-search') && !target.classList.contains('dropdown-item')) {
					dropdown.addClass('hidden');
					// reset the input field text, if it was edited without selecting new option from the dropdown
					if (input.attr('data-product-name') && input.val() != input.attr('data-product-name')) {
						input.val(input.attr('data-product-name'));
					}
				}
			});

			dropdownItems.on('click', function (event) {
				var optionId = event.currentTarget.id,
					optionText = event.currentTarget.innerText;

				dropdown.addClass('hidden');
				input.val(optionText);
				input.attr('data-product-id', optionId);
				input.attr('data-product-name', optionText);
				// triggers the input event on the search input, so the ajax request is made
				$('.input-search').trigger('input');
			});

			input.on('input', function (event) {
				var inputText = event.currentTarget.value.trim();
				var filterAttributes = [
					'data-name'
				];
				$self.filterElementsByAttribute(inputText, dropdownItems, filterAttributes);
			});
		}

		// Currently used in Admin->Models and Admin->Products pages
		this.setInputFilters = function () {
			var inputs = $('.filter-input');
			var btnClearFilters = $('.btn-clear-filters');
			var filterableElements = $('.filterable-element');

			inputs.on('input', function (event) {
				// First check the current input, then all others
				var inputText = event.currentTarget.value.trim();
				var filterAttributes = [
					event.currentTarget.dataset.searchAttribute
				];
				$self.filterElementsByAttribute(inputText, filterableElements, filterAttributes);

				// After the current input is checked, search only through the visible elements
				var visibleElements = $('.filterable-element:visible');

				// Check other inputs, without the current one
				for (var i = 0; i < inputs.length; i++) {
					var input = inputs[i];
					// Current input is already checked, ignore it
					if (input != event.currentTarget && input.value != '') {
						var inputText = input.value.trim();
						var filterAttributes = [
							input.dataset.searchAttribute
						];
						$self.filterElementsByAttribute(inputText, visibleElements, filterAttributes);
					}
				}
			});

			btnClearFilters.on('click', function() {
				inputs.val('');
				var elements = $('.filterable-element');
				elements.show();
			});
		}

		// Filter elements by a given data-attributes to search through
		// text - the text from the input field
		// elements - array of the elements to be filtered
		// filterAttributes - array with the attributes to be searched for
		this.filterElementsByAttribute = function (text, elements, filterAttributes) {
			elements.filter(function () {
				var match;
				for (var filterAttr of filterAttributes) {
					match = this.attributes[filterAttr].value.toLowerCase().indexOf(text.toLowerCase()) > -1;
					if (match) {
						break;
					} else {
						$(this).hide();
					}
				}
				return match;
			}).show();
		}
  }

$(function () {
  if (!window.console) window.console = {};
  if (!window.console.log) window.console.log = function () {};
  if (!window.console.info) window.console.info = function () {};

  uvel = new uvelController();
  uvel.init();
});
