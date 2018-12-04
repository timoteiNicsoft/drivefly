$(document).on('click', '.save_product', function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  var product_id = $(this).data('product_id');
  var content = $(this).data('content');
  var editor = $(this).data('editor');
  var quill = new Quill('#'+editor);
  var editor_content = quill.container.innerHTML;
  $.ajax({
    url: '/ajax_save_content_product',
    method: 'post',
    data: {id : product_id, field : content, text: editor_content}
  }).done(function(data) {

   });
})

$(document).on('click', '.submit_changes_product', function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  var form = $(this).parents('form:first');
  submit_form_ajax(form);
})
function submit_form_ajax(form){
  $(form).submit(function(e){
    e.preventDefault();
    var form = this;
    $.ajax({
      url: $(form).attr('action'),
      type:'post',
      data:new FormData($("#upload_form")[0]),
      processData: false,
      contentType: false,
    }).done(function(data) {
      $('#image_'+data.product_id+' img').attr('src', data.image_url);
      $('#alert_main_content_'+data.product_id).html('<div class="alert alert-info mb-3" role="alert">'+data.message+'</div>');
    });
  })
}

$(document).on('click', '.send_show_hide_glag', function(e){
  e.preventDefault();
  e.stopPropagation();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  var button = this;
  var product_id = $(this).data('product_id');
  var val = $(this).data('value');
  $.ajax({
    url: '/ajax_save_show_hide_product',
    method: 'post',
    data: {id : product_id, value : val}
  }).done(function(data) {
    if($(button).hasClass('btn-default')){
      $(button).removeClass('btn-default');
      $(button).addClass('btn-success');
      $(button).html('On');
    }else{
      $(button).removeClass('btn-success');
      $(button).addClass('btn-default');
      $(button).html('Off');
    }
  });
})
