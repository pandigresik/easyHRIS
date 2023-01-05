import _ from 'lodash'
class ElementGenerator {
  input (options, listItem) {
    const _attribute = []
    _.forEach(options, (elm, i) => {
      _attribute.push(i + "='" + elm + "'")
    })
    if (_.isEmpty(listItem)) {
      if (options.elements) {
        const _result = []
        for (const i in options.elements) {
          _result.push(`<div class="form-group col-sm-6"><input data-position="${options.elements[i]}" ${_.join(_attribute, ' ')} /></div>`)
        }
        return `<div class="row">${_.join(_result, ' ')}</div>`
      } else {
        return `<div class="row"><div class="form-group col-sm-12"><input ${_.join(_attribute, ' ')} /></div></div>`
      }
    } else {
      return this.dropdown(_attribute, listItem)
    }
  }

  dropdown (options, listItem) {
    const _optionItem = []
    _.forEach(listItem, function (item) {
      _optionItem.push(`<option value="${item.value}">${item.text}</option>`)
    })
    return `<div class="row"><div class="form-group col-sm-12"><select ${_.join(options, ' ')}>${_.join(_optionItem, ' ')}</select></div></div>`
  }

  inputSearch (element, _optionElement) {
    const _title = element.title || ''
    const _defaultOption = {
      type: 'text',
      style: 'width:100%',
      placeholder: 'Search ' + _title
    }
    const _listItem = element.listItem ?? null
    if (_listItem) {
      // @ts-ignore
      delete _optionElement.listItem
    }
    const localOption = _optionElement.localOption
    // @ts-ignore
    delete _optionElement.localOption
    const _options = {
      ..._defaultOption,
      ..._optionElement
    }
    switch (element.elmsearch) {
      case 'daterange':
        _options.class = 'form-control datetime'
        _options['data-optiondate'] = JSON.stringify(localOption.daterange_search)
        break
      case 'datetimerange':
        _options.class = 'form-control datetime'
        _options['data-optiondate'] = JSON.stringify(localOption.datetimerange_search)
        break
      case 'datesingle':
        _options.class = 'form-control datetime'
        break
      case 'time':
        _options.class = 'form-control datetime'
        _options['data-optiondate'] = JSON.stringify(localOption.time)
        break
      case 'numberrange':
        _options.class = 'form-control inputmask'
        _options['data-optionmask'] = JSON.stringify(localOption.number.decimal)
        _options.elements = ['from', 'to']
        break
      case 'decimal':
        _options.class = 'form-control inputmask'
        _options['data-optionmask'] = JSON.stringify(localOption.number.decimal)
        break
      case 'currency':
        _options.class = 'form-control inputmask'
        _options['data-optionmask'] = JSON.stringify(localOption.number.currency)
        break
      case 'dropdown':
        _options.class = 'form-control select2'
        break
      default:
        _options.class = 'form-control'
    }

    return this.input(_options, _listItem)
  }
}

export default new ElementGenerator()
