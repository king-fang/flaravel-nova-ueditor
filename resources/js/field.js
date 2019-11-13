Nova.booting((Vue, router, store) => {
  Vue.component('index-noav-ueditor', require('./components/IndexField'))
  Vue.component('detail-noav-ueditor', require('./components/DetailField'))
  Vue.component('form-noav-ueditor', require('./components/FormField'))
})
