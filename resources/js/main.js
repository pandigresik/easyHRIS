import _ from 'lodash'
import $ from 'jquery'
import 'jquery-validation'
import 'jquery.redirect/jquery.redirect'
import 'jquery-serializejson'
import './basePath.js'
import 'ckeditor4'
import 'ckeditor4/adapters/jquery'
import bootbox from 'bootbox'

import {
  Calendar
} from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import FileUploadWithPreview from 'file-upload-with-preview'

class Main {
  setWorkflow(f) {
    this.workflow = f
  }

  setButtonCaller(elm) {
    $('.button-caller').removeClass('button-caller');
    $(elm).addClass('button-caller');
  }

  executeWorkflow() {
    if (!_.isEmpty(this.workflow)) {
      const _target = this.workflow.shift()
      $(_target.element).trigger('click')
    }
  }

  getAjaxData(_url, _type, _data, _callback) {
    // @ts-ignore
    $.ajax({
      url: _url,
      data: _data,
      dataType: 'json',
      type: _type,
      beforeSend: function() {},
      success: function(data) {

      }
    }).done(function(data) {
      if (_callback !== undefined) {
        _callback(data)
      }
    })
  }

  alertDialog(title, message, callback) {
    bootbox.alert({
      title: title,
      message: message,
      buttons: {
        ok: {
          label: 'OK',
          className: 'btn-primary btn-sm'
        }
      },
      callback(result) {
        if (callback !== undefined) {
          callback(result)
        }
      }
    })
  }

  resetForm(elm) {
    const _form = $(elm).closest('form')
    const _exclude = $(elm).data('exclude')
    _form.find('input,textarea').not($(elm)).not(_exclude).val('')
    _form.find('select').not($(elm)).not(_exclude).each(function() {
      $(this).val($(this).find('option:first').val())
    })
  }

  getHtmlData(_url, _type, _data, _callback) {
    let _ini = this;
    // @ts-ignore
    $.ajax({
      url: _url,
      data: _data,
      dataType: 'html',
      type: _type,
      beforeSend: function() {
        _ini.showLoading(true)
      },
      success: function(data) {
        _ini.showLoading(false)
      },      
      error: function (xhr, status, text) {
        _ini.showLoading(false)
				const pesan = xhr.responseText;
				bootbox.alert('Terjadi error di server \n' + pesan, function () {});
			}
    }).done(function(data) {
      if (_callback !== undefined) {
        _callback(data)
      }
    })
  }

  showLoading(state) {
    if (state) {
      this.bootboxInfo = bootbox.alert({
            message: 'Please wait ........',
            callback: function(result){
                return false;
            },
            buttons: {
                ok: {
                    className: 'fade'
                }
            }
        });
    } else {
      try {
        const _ini = this
        setTimeout(function() {
          _ini.bootboxInfo.modal('hide')
        }, 500)
      } catch (e) {

      }
    }
  }

  loadContent(_url, _data, _type, _target, _callback) {
    const _mainElm = $(_target)
    const _ini = this
    // @ts-ignore
    $.ajax({
      url: _url,
      data: _data,
      dataType: 'html',
      type: _type,
      beforeSend: function() {
        _mainElm.html('Loading ......')
      },
      success: function(data) {
        _mainElm.html(data)
      },
      error: function (xhr, status, text) {
        _ini.showLoading(false)
				const pesan = xhr.responseText;
				bootbox.alert('Terjadi error di server \n' + pesan, function () {});
			}
    }).done(function() {
      _ini.initFormatInput(_mainElm)
      if (_callback !== undefined) {
        _callback()
      }
      _ini.executeWorkflow()
    })
  }

  getContentView(_url, _data, _target, refreshFn = function() {}) {
    this.loadContent(_url, _data, 'GET', _target, refreshFn)
  }

  postContentView(_url, _data, _target, refreshFn = function() {}) {
    this.loadContent(_url, _data, 'POST', _target, refreshFn)
  }

  defaultValidateOption() {
    return {
      errorElement: 'em',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback')
        if (element.prop('type') === 'checkbox') {
          error.insertAfter(element.parent('label'))
        } else {
          error.insertAfter(element)
        }
      },
      highlight: function(element) {
        $(element).addClass('is-invalid').removeClass('is-valid')
      },
      unhighlight: function(element) {
        $(element).addClass('is-valid').removeClass('is-invalid')
      }
    }
  }

  checkAll(elm, parent){
    const _checked = $(elm).is(':checked') ? 1 : 0                
    $(elm).closest(parent).find(':checkbox').not(elm).prop('checked', _checked)
  }

  initFormatInput(_closestTarget) {
    const _ini = this
    const _tmpTarget = _closestTarget === undefined ? $('form') : _closestTarget
    const _tagName = _tmpTarget.prop('tagName')
    const _target = _tmpTarget
    const _targetForm = _tagName === 'FORM' ? _tmpTarget : _tmpTarget.find('form')
    _targetForm.each(function() {
      const _container = $(this).find('div.form-error-validate-container')
      const _setContainerError = $(this).data('error-container')
      const _objValidateTmp = {
        submitHandler: function(_form) {
          const _submit = $(_form).data('submitable') ?? 1
          $(_form).find('.inputmask').each(function() {
            if ($(this).data('unmask')) {
              // @ts-ignore
              const _option = $(this).data('optionmask') || {}
              let _unmaskedvalue = $(this).inputmask('unmaskedvalue')
              if (_option.radixPoint === ',') {
                _unmaskedvalue = _unmaskedvalue.replace(',', '.')
              }
              $(this).inputmask('remove')
              $(this).val(_unmaskedvalue)
            }
          })

          $(_form).find('.datetime').each(function() {
            if ($(this).data('daterangepicker') !== undefined) {
              const _val = _ini.getValueDateSQL($(this))
              $(this).data('daterangepicker').remove()
              $(this).val(_val)
            }
          })

          if (_submit) {
            _form.submit()
          }

        },
      }
      const _defaultObjValidate = _ini.defaultValidateOption()
      const _objValidate = {
        ..._defaultObjValidate,
        ..._objValidateTmp
      }
      if (_setContainerError !== undefined) {
        _objValidate.errorLabelContainer = _container
      };
      $(this).validate(_objValidate)
    })

    _ini.initDatetime(_target)
    _ini.initInputmask(_target)
    _ini.initSelect(_target)
    _ini.initEditor(_target)
    _ini.initCalendar(_target)
  }

  initFormatInputWithoutValidate(_closestTarget) {
    const _ini = this
    const _tmpTarget = _closestTarget === undefined ? $('form') : _closestTarget
    const _target = _tmpTarget

    _ini.initDatetime(_target)
    _ini.initInputmask(_target)
    _ini.initSelect(_target)
    _ini.initEditor(_target)
    _ini.initCalendar(_target)
  }

  initInputFile(_target) {
    const uploadFile = []
    _target.find('.upload-file').each(function() {
      const _defaultOption = {
        showDeleteButtonOnImages: true,
        text: {
          chooseFile: 'Custom Placeholder Copy',
          browse: 'Custom Button Copy',
          selectedCount: 'Custom Files Selected Copy'
        }
      }
      const _optionUpload = $(this).data('optionupload') || {}
      const _option = {
        ..._defaultOption,
        ..._optionUpload
      }
      uploadFile.push(FileUploadWithPreview($(this).attr('id'), _option))
    })
  }

  initInputmask(_target) {
    _target.find('.inputmask').each(function() {
      const _option = $(this).data('optionmask') || {}
      const _type = $(this).attr('type')
      const _allowedElement = ['text', 'url', 'search', 'tel', 'password']
      if (_type !== undefined) {
        if (!_.find(_allowedElement, _type)) {
          $(this).attr('type', 'text')
        }
      }
      // @ts-ignore
      $(this).inputmask(_option)
    })
  }

  initDatetime(_target) {
    _target.find('.datetime').each(function() {
      const _optionDate = $(this).data('optiondate') || {}
      const _defaultOption = {
        locale: {
          format: 'DD MMM YYYY'
        },
        singleDatePicker: true,
        timePicker: false,
        showDropdowns: true,
        autoApply: true
        // autoUpdateInput: true
      }
      const _option = {
        ..._defaultOption,
        ..._optionDate
      }
      // @ts-ignore
      if (_optionDate.hideDatePicker === false) {
        $(this).daterangepicker(_option).on('show.daterangepicker', function(ev, picker) {
          picker.container.find('.calendar-table').hide()
        })
      } else {
        $(this).daterangepicker(_option)
      }

      if(!_option.autoApply){
         $(this).on('apply.daterangepicker', function(ev, picker) {
            if(_option.singleDatePicker){
              $(this).val(picker.startDate.format(_option.locale.format));
            }else{
              $(this).val(picker.startDate.format(_option.locale.format) + ' - ' + picker.endDate.format(_option.locale.format));
            }
              
         });

         $(this).on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
         });
      }
    })
  }

  initEditor(_target) {
    _target.find('.editor').each(function() {
      const _optionEditor = $(this).data('optioneditor') || {}
      // @ts-ignore
      $(this).ckeditor(_optionEditor)
    })
  }

  initSelect(_target) {
    const _ini = this
    _target.find('.select2').each(function() {
      const _optionSelect = $(this).data('optionselect') || {}
      const _firstOption = $(this).find('option').eq(0)
      let _placeholder = $(this).data('placeholder') || 'Choose option'
      // if (_.isEmpty(_firstOption.val())) {
      //   _placeholder = _firstOption.text()
      // }
      const _defaultOption = {
        width: '100%',
        allowClear: true,
        placeholder: _placeholder
      }
      const _option = {
        ..._defaultOption,
        ..._optionSelect
      }
      const _isAjax = $(this).data('ajax') || false
      if (_isAjax) {
        const _ini = $(this)
        const _url = _ini.data('url')
        const _repository = _ini.data('repository')        
        if (_url === undefined) {
          console.log('url select2 ' + $(this).attr('name') + ' belum diset')
        } else {
          _option.ajax = {
            url: _url,
            type: 'get',
            dataType: 'json',
            delay: 500,
            data: function(params) {
              return {
                q: $.trim(params.term), // search term
                page: params.page,
                repository: _repository,
                filter: _ini.data('filter')
              }
            },
            processResults: function(data) {
              data.page = data.from || 1
              return {
                results: data.data,
                pagination: {
                  more: !!data.next_page_url
                }
              }
            },
            cache: true
          }
        }
      }
      const _hasIcon = $(this).data('hasicon') || false
      const _asTable = $(this).data('astable') || false
      const _asCard = $(this).data('ascard') || false
      const _selectAsCard = $(this).data('selectascard') || false
      if (_hasIcon) {
        _option.templateSelection = _ini.formatText
        _option.templateResult = _ini.formatText
      }
       
      if(_asTable){
        _firstOption.prop('disabled',1)
        _option.templateSelection = _ini.formatTable
        _option.templateResult = _ini.formatTable
      }

      if(_asCard){
        if(_selectAsCard){
          _option.templateSelection = _ini.formatCard
        }        
        _option.templateResult = _ini.formatCard
      }
      
      $(this).select2(_option)
    })
  }

  formatText(icon) {
    const _icon = $(icon.element).data('icon') ?? icon.text
    return $('<span><i class="' + _icon + '"></i> ' + icon.text + '</span>')
  }

  formatTable(item) {
    const _item = item.text.split(' | ')
    let _maxWidth = Math.ceil(12  / _item.length)
    if(_maxWidth < 2){
      _maxWidth = 2
    }
    const _classColumn = 'col-md-'+_maxWidth
    const _child = []
    for(let i in _item){
      _child.push(`<div class="${_classColumn}">${_item[i]}</div>`)
    }    

    return $(`<div class="row">${_child.join('')}</div>`)
  }

  formatCard(item) {
    const _item = item.text.split(' | ')    
    const _child = []
    let _keyValue
    for(let i in _item){
      _keyValue = _item[i].split('::')
      _child.push(`<tr><td class="p-2">${_keyValue[0]}</td><td class="text-end p-2">${_keyValue[1]}</td></tr>`)
    }    

    return $(`<div class="pr-3"><table class="table table-sm table-dark"><tbody>${_child.join('')}</tbody></table></div>`)
  }

  initCalendar(_target) {
    _target.find('.calendar').each(function() {
      const _elm = document.getElementById($(this).attr('id'))
      const _eventSourcesUrl = $(this).data('eventurl')
      const _defaultOption = {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
        initialView: 'dayGridMonth',
        height: 650,
        showNonCurrentDates: false,
        eventSources: [{
          url: _eventSourcesUrl,
          type: 'POST',
          data: {
            /* custom_param1: 'something',
                          custom_param2: 'somethingelse' */
          },
          error: function() {
            alert('there was an error while fetching events!')
          },
          color: 'none', // a non-ajax option
          textColor: 'black' // a non-ajax option
        }],
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        html: true,
        /*
            dayRender: function(date, cell) {

                var check = $.fullCalendar.formatDate(date, 'Y-MM-DD');
                for (var i = 0; i <= event.length - 1; i++) {
                    var thisevent = event[i].start;
                    if (check == thisevent) {
                        cell.css("background-color", event[i].color);
                    }
                }
        }, */
        eventRender: function(event, element) {
          if (!_.isEmpty(event.className)) {
            // $day = $date.getDate();
            const title = element.find('.fc-title')
            title.html(title.text())
            $("td.fc-day[data-date='" + event.start.format('YYYY-MM-DD') + "']").addClass(event.className.join(' '))
          }
        }
      }
      const _optionCalendar = $(this).data('optioncalendar') || {}

      const _option = {
        ..._defaultOption,
        ..._optionCalendar
      }
      // @ts-ignore
      const calendar = new Calendar(_elm, _option)
      calendar.render()
    })
  }

  popupModal(elm, _type, _callback) {
    const _data = $(elm).data('json')
    const _url = $(elm).data('url')
    const _title = $(elm).data('title') || ''
    const _ini = this
    const _size = $(elm).data('size') === undefined ? 'extra-large' : $(elm).data('size')
    this.getHtmlData(_url, _type, _data, function(data) {
      const _options = {
        size: _size,
        title: _title,
        message: data,
        scrollable: true
      }
      bootbox.dialog(_options).on('shown.coreui.modal', function(e) {
        const _dialog = $(e.target)
        _ini.initFormatInput(_dialog)
      });
    })
  }

  loadDetailPage(elm, _type, _callback) {
    let _data = $(elm).data('json')
    const _url = $(elm).data('url')
    const _ref = $(elm).data('ref')
    const _refElm = $(_ref)
    const _target = $(elm).data('target')
    if (_data === undefined) {
      if (_.isEmpty($(elm).val())) {
        $(_target).html('')
        return
      }
      _data = {
        id: $(elm).val()
      }
    }
    if (_refElm.length) {
      if(_refElm.length > 1){
        _refElm.each(function(){
          _data[$(this).attr('name')] = $(this).val()
        });
      }else{
        _data.ref = _refElm.val()
      }
      
    }
    this.getHtmlData(_url, _type, _data, function(data) {
      $(_target).html(data)
      if (_callback !== undefined) {
        _callback(data)
      }
    })
  }

  redirectUrl(elm) {
    const _url = $(elm).data('url')
    let _json = $(elm).closest('tr').data('json')
    const _type = $(elm).data('tipe') || 'post'
    if (_json === undefined) {
      _json = $(elm).data('json')
    }
    let _target = '_blank'
    if ($(elm).data('target') !== undefined) {
      _target = $(elm).data('target')
    }
    // @ts-ignore
    $.redirect(
      _url, _json,
      _type,
      _target
    )
  }

  loadContentTab(elm) {
    const _url = $(elm).data('url')
    const _json = $(elm).data('json')
    const _href = $(elm).data('href')
    const _target = $(_href)
    if (_.isEmpty(_target.html())) {
      this.getContentView(_url, {
        key: _json
      }, _target)
    }
  }

  clickElm(elm, _target) {
    const _data = $(elm).data()
    if (_data !== undefined) {
      for (const _i in _data) {
        $(_target).data(_i, _data[_i])
      }

      const _href = $(_target).data('href')
      this._clearHtmlData($(_href))
      switch ($(_target).data('action')) {
        case 'add':
          $(_target).find('i').removeClass('fa-pencil')
          $(_target).find('i').addClass('fa-plus')
          break

        default:
          $(_target).find('i').removeClass('fa-plus')
          $(_target).find('i').addClass('fa-pencil')
      }
    }
    $(_target).click()
  }

  _clearHtmlData(_targetHtml) {
    _targetHtml.html('')
  }

  editRecord(elm) {
    const _key = $(elm).closest('tr').data('key')
    const _url = $(elm).data('url')
    this.postContentView(_url, {
      key: _key
    })
  }

  refresh(_url) {
    if (_url) {
      window.location.href = _url
    } else {
      // @ts-ignore
      window.reloadPage()
    }
  }

  setRequiredElm(elm) {
    const _parent = $(elm).data('parent')
    const _target = $(elm).data('target')
    const _elmTarget = $(elm).closest(_parent).find(_target).not($(elm))
    if ($(elm).is(':checked')) {
      _elmTarget.prop('required', true)
    } else {
      _elmTarget.prop('required', false)
    }
  }

  autofocus(elm) {
    const _position = $(elm).offset()
    $(document).scrollTop(_position.top - 100)
  }

  autofocusCarousel(elm) {
    let _position = $(elm).offset()
    const _inCarousel = $(elm).closest('.carousel-item')
    if (_inCarousel.length) {
      if (!_inCarousel.hasClass('active')) {
        _inCarousel.siblings('.active').removeClass('active')
        _inCarousel.addClass('active')
        setTimeout(function() {
          _position = $(elm).offset()
          $(document).scrollTop(_position.top - 100)
        }, 500)
      } else {
        $(document).scrollTop(_position.top - 100)
      }
    }
  }

  getValueDateSQL(elm) {
    let result = null
    try {
      if(_.isEmpty($(elm).val())) return ''
      const _v = $(elm).data('daterangepicker')
      let _format = 'YYYY-MM-DD'
      // @ts-ignore
      const _localFormat = _v.locale.format
      if (_.includes(_localFormat, 'YYYY')) {
        _format = 'YYYY-MM-DD'
        if (_.includes(_localFormat, 'HH')) {
          _format += ' ' + 'HH:mm:ss'
        }
      } else {
        _format = 'HH:mm:ss'
      }

      // @ts-ignore
      if (!_v.singleDatePicker) {
        result = `${_v.startDate.format(_format)}__${_v.endDate.format(_format)}`
      } else {
        result = _v.startDate.format(_format)
      }
    } catch (e) {
      console.error(e)
    }
    return result
  }

  generateFormField(_prefix, _json) {
    const _form = []
    for (const _i in _json) {
      _form.push(`<input type='hidden' name='${_prefix}[${_i}]' value='${_json[_i]}' >`)
    }
    return _form
  }

  addRow(_elm, _callback) {
        let _tr = $(_elm).closest("tr");
        let _tbody = _tr.closest("tbody");
        let _newTr = _tr.clone();
        let _target = $(_elm).data('target');
        let _urut = _newTr.find("td.no").text();
        _newTr.find("input").not(':checkbox,:radio').val("");
        _newTr.find("td.no").text(++_urut);
        if (_target !== undefined) {
            switch (_target) {
                case 'before':
                    _newTr.insertBefore(_tr);
                    break;
                default:
                    _newTr.insertAfter(_tr);
            }
        } else {
            _tbody.append(_newTr);
        }

        $(_elm).replaceWith(
            '<button onclick="main.removeRow(this)" class="btn btn-primary btn-sm"><i class="fa fa-minus"></i></button>'
        );
        _newTr.find("input").trigger("change");        
        if (_callback !== undefined) {
            _callback(_newTr);
        }
    }

    removeRow(_elm, _callback) {
        let _tr = $(_elm).closest("tr");
        _tr.remove();
        if (_callback !== undefined) {
            _callback();
        }
    }
}

export default new Main()
