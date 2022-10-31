@section('css')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('scripts')
    @include('layouts.datatables_js')
    <script>
        const columnSearch = {!! json_encode($dataTable->getOptions()['columns']) !!}
        const newTr = $('#dataTableBuilder thead>tr').clone();
        let localOption = {}
         
        _.forEach(columnSearch, (element, i, array) => {
            let _th = newTr.find('th').eq(i)
            localOption = {'localOption' : {!! json_encode(config('local')) !!} }
            if(!element.searchable){
                if(i === array.length -1){
                    _th.html('<div class="row"><div class="form-group col-sm-12"><button class="btn btn-primary search-btn"><i class="cil cil-search"></i></button></div></div>')
                    _th.on( 'click','button.search-btn', function () {
                        if (window.LaravelDataTables === undefined){

                            return;
                        }
                        const table = window.LaravelDataTables.dataTableBuilder
                        const _tr = _th.closest('tr')
                        const _columnSearch = []
                        _tr.find('th').not(_th).each(function(i, elm){
                            let _searchValue = []                            
                            $(elm).find('input, select').each(function(j, _input){
                                let _searchValueTmp = $(_input).val()
                                
                                const _className = _input.className
                                if(_.includes(_className,'datetime')){
                                    _searchValueTmp = main.getValueDateSQL(_input)
                                }
                                if(_.includes(_className,'inputmask')){
                                    const _optionMask = $(_input).data('optionmask') || {}
                                    _searchValueTmp = $(_input).inputmask('unmaskedvalue')
                                    if (_optionMask.radixPoint === ',') {
                                        _searchValueTmp = _searchValueTmp.replace(',', '.')
                                    }
                                }
                                _searchValue.push(_searchValueTmp)
                            })
                            _columnSearch[i] = _.join(_searchValue,'__')
                            
                        })
                        
                        for(const i in _columnSearch){
                            table
                            .column(i)
                            .search(_columnSearch[i] )
                        }
                        table.draw()
                    })
                }else{
                    _th.html('')
                }
                
                return
            }
            if(element.multiple){
                localOption['multiple'] = element.multiple
            }
            _th.html(window.elementGenerator.inputSearch(element,localOption))
        })
        main.initFormatInput($(newTr));
        $(newTr).appendTo($('#dataTableBuilder thead'));
    </script>
    {!! $dataTable->scripts() !!}
@endpush
