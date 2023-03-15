// @ts-nocheck
import './bootstrap'
window.main = require('./main').default
window.elementGenerator = require('./elementGenerator').default

function ready (callbackFunc) {
  if (document.readyState !== 'loading') {
    // Document is already ready, call the callback directly
    callbackFunc()
  } else if (document.addEventListener) {
    // All modern browsers to register DOMContentLoaded
    document.addEventListener('DOMContentLoaded', callbackFunc)
  } else {
    // Old IE browsers
    // @ts-ignore
    document.attachEvent('onreadystatechange', function () {
      if (document.readyState === 'complete') {
        callbackFunc()
      }
    })
  }
}

ready(function () {
  $('form').each(function(){
    window.main.initFormatInput($(this))
  })
  
  $(document).on('select2:open', () => {
      let allFound = document.querySelectorAll('.select2-container--open .select2-search__field');
      allFound[allFound.length - 1].focus();
  });
})