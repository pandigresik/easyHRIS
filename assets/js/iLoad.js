'use strict';

$(function(){
  /* format date */
  $('input[name$=Date]').datepicker({
    dateFormat : 'dd M yy',
     locale:'id',
    onSelect: function(date) {
      var _n = $(this).attr('name');
      if(_n == 'startDate'){
        $('input[name=endDate]').datepicker('option','minDate',date);
      }else{
        $('input[name=startDate]').datepicker('option','maxDate',date);
      }
    },
  });

  /* format date */
  $('[data-tipe=date]').datetimepicker({
     format: 'DD MMM YYYY',
     locale:'id',
     minDate : moment().format('YYYY-MM-DD'),
  });

  /* format numeral*/
  $('[data-tipe=integer],[data-tipe=angka],[data-tipe=decimal]').each(function(){
    $(this).priceFormat(Config[$(this).data('tipe')]);
  });

  /* format alpha-numeric */
  $('[data-tipe=alpha-numeric]').keyup(function() {
      if (this.value.match(/[^a-zA-Z0-9]/g)) {
          this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
      }
  });

  $('a[load]').click(function(event) {
    event.preventDefault();
    var url = $(this).attr('load');
    App.loadContentView(url);
  });

});
