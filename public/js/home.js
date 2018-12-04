request = {
  service: '0',
  airport: '0',
  consolidator: '0',
  terminal: '0'
};
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
function refresh()
{
  $('.list_container').html($('.loader_container').html());

  $.ajax({
    url: '/ajax_reports',
    method: 'post',
    data: request
  }).done(function(data){
    $('.list_container').html($('.list_header_container').html());

    for (var reportIndex in data) {
      var listEntry = $($('.list_item_template').html());

      for (var reportProperty in data[reportIndex]) {
        // console.log(listEntry.find('.data_' + reportProperty));
        listEntry.find('.data_' + reportProperty).each(function(index, element) {
          $(element).html(data[reportIndex][reportProperty]);
        });

        listEntry.find('span[data-original-title="data_' + reportProperty + '"]').each(function(index, element) {
          $(element).attr('data-original-title', data[reportIndex][reportProperty]);

          $(element).tooltip()
        });

            /*
            if(data[reportIndex]['xpayment'] != '') {
                listEntry.find('.indata_' + reportProperty).each(function(index, element) {
                    $(element).html('<span class="fas fa-piggy-bank indata_xpayment" data-toggle="tooltip" data-placement="top" title="'+data[reportIndex][reportProperty]+'"></span>');
                });
            }
            */

            if(data[reportIndex]['notes'] != '') {
              listEntry.find('.indata_' + reportProperty).each(function(index, element) {
                $(element).html('<span class="fas fa-tag indata_notes" data-toggle="tooltip" data-placement="top" title="'+data[reportIndex][reportProperty]+'"></span>');
              });
            }
      }

      switch (data[reportIndex]['status']) {
        case 'OK': listEntry.addClass('bg-white'); break;
        case 'Paid': listEntry.addClass('bg-white'); break;
        case 'Booked': listEntry.addClass('alert-secondary'); break;
        case 'Amended' : listEntry.addClass('alert-secondary'); break;
        case 'Active' : listEntry.addClass('alert-secondary'); break;
        case 'Pending': listEntry.addClass('alert-warning text-dark'); break;
        case 'No Show': listEntry.addClass('alert-warning text-dark'); break;
        case 'Cancelled': listEntry.addClass('alert-warning text-dark'); break;
        default: listEntry.addClass('bg-white');
      }

      listEntry.find('.data_color_selector_leavingDate').each(function(index, element) {
        switch (data[reportIndex]['status']) {
          case 'OK': $(element).addClass('text-success'); break;
          case 'Paid': $(element).addClass('text-success'); break;
          case 'Booked': $(element).addClass('text-warning'); break;
          case 'Amended': $(element).addClass(''); break;
          case 'Active': $(element).addClass(''); break;
          case 'Pending': $(element).addClass('text-warning'); break;
          case 'No Show': $(element).addClass('text-warning'); break;
          case 'Cancelled': $(element).addClass(''); break;
          default: $(element).addClass('bg-white');
        }
      });

      listEntry.find('.data_color_selector_status').each(function(index, element) {
        switch (data[reportIndex]['status']) {
          case 'OK': $(element).addClass('badge-success'); break;
          case 'Paid': $(element).addClass('badge-success'); break;
          case 'Booked': $(element).addClass('badge-success'); break;
          case 'Amended': $(element).addClass('badge-success'); break;
          case 'Active': $(element).addClass('badge-success'); break;
          case 'Pending': $(element).addClass('badge-warning'); break;
          case 'No Show': $(element).addClass('badge-warning'); break;
          case 'Cancelled': $(element).addClass('badge-danger'); break;
          default: $(element).addClass('bg-white');
        }
      });

      listEntry.attr('data-report-id', data[reportIndex]['id']);

      $('.list_container').append(listEntry);
    }
  });
}

$(document).ready(function() {

  $('.property_refresh_check').on('change', function(event) {
    var classList = $(event.currentTarget).attr('class').split(/\s+/);
    $.each(classList, function(index, item) {
      if (item.indexOf('property_name_') === 0) {
        request[item.substr(14)] = $(event.currentTarget).attr('value');

        if(request[item.substr(14)] == 2) {
          $('.list_container').css({'background-color':'rgba(240, 173, 78, 0.12) !important'});
        }
        else {
          $('.list_container').css({'background-color':'#eaeaea'});
        }
      }
    });

    refresh();
  });

  $('.property_refresh_select').on('click', function(event) {
    var name = '';
    var value = '0';

    var classList = $(event.currentTarget).attr('class').split(/\s+/);
    $.each(classList, function(index, item) {
      if (item.indexOf('property_name_') === 0) {
        name = item.substr(14);
      }
      if (item.indexOf('property_value_') === 0) {
        value = item.substr(15);
      }
    });

    if (name != '') {
      request[name] = value;

      refresh();
    }
  });

  refresh();
});

Dropzone.autoDiscover = false;

var myDropzone = null;
var reportId = 0;

$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  myDropzone = new Dropzone('.dropzone', {
    url: '/image_upload',
    acceptedFiles: 'image/*',
    thumbnailWidth: 75,
    thumbnailHeight: null,
    addRemoveLinks: true,
    removedfile: function(file) {
      Dropzone.confirm('Do you want to delete?', function() {
        $.ajax({
          url: '/image_delete',
          type: 'post',
          cache: false,
          dataType: 'json',
          traditional: true,
          data: { id: file.id },
          success: function (data) {
            $(document).find(file.previewElement).remove();
          },
          error: function (err) {
            alert('Failed to delete file (' + err.status + ').');
          }
        });
      }, function() { return false; });
    }
  });

  myDropzone.on('sending', function(file, xhr, formData) {
    formData.append('report', reportId);
  });

  $('.dropzone').on('click', '.dz-preview', function(event) {
    window.open($(event.currentTarget).find('img').attr('src').replace('.jpg', '-original.jpg'), '_blank');
  });

     // shareable
  $('#editReportModal').on('show.bs.modal', function (event) {

  $('#editReportModal').find('.modal-content > div').each(function(index, element) {
    if ($(element).hasClass('modal-loader')) {
      $(element).show();
    } else {
      $(element).hide();
    }
  });

  reportId = $(event.relatedTarget).data('report-id');

  $.ajax({
    url: '/ajax_report',
    method: 'post',
    data: { report: $(event.relatedTarget).data('report-id') }
  }).done(function(data) {
    $('.dropzone').find('.dz-preview').remove();

    $.ajax({
      url: '/image_upload',
      type: 'get',
      cache: false,
      traditional: true,
      data: { report: reportId }
    }).done(function(data) {
      $.each(data, function(key,value) {
        var mockFile = { id: value.id, name: value.name, size: value.size, reportId: value.reportId };

        myDropzone.emit('addedfile', mockFile);

        myDropzone.emit('thumbnail', mockFile, 'data/images/' + value.name);

        myDropzone.emit('complete', mockFile);
      });
    });

    for (var reportProperty in data) {
      $('#editReportModal').find('.data_' + reportProperty).each(function(index, element) {
        if ($(element).is('input') || $(element).is('textarea')) {
          $(element).val(data[reportProperty]);
        } else {
          $(element).html(data[reportProperty]);
        }
      });
    }

    $('#editReportModal').find('.data_color_selector_status').each(function(index, element) {
      switch (data['status']) {
        case 'OK': $(element).addClass('badge-success'); $(element).removeClass('badge-warning badge-danger'); break;
        case 'Paid': $(element).addClass('badge-success'); $(element).removeClass('badge-warning badge-danger'); break;
        case 'Booked': $(element).addClass('badge-success'); $(element).removeClass('badge-warning badge-danger'); break;
        case 'Amended': $(element).addClass('badge-success'); $(element).removeClass('badge-warning badge-danger'); break;
        case 'Active': $(element).addClass('badge-success'); $(element).removeClass('badge-warning badge-danger'); break;
        case 'Pending': $(element).addClass('badge-warning'); $(element).removeClass('badge-success badge-danger'); break;
        case 'Cancelled': $(element).addClass('badge-danger'); $(element).removeClass('badge-warning badge-success'); break;
        default: $(element).addClass('bg-white');
      }
    });

    $('#editReportModal').find('.modal-content > div').each(function(index, element) {
      if ($(element).hasClass('modal-loader')) {
        $(element).hide();
      } else {
        $(element).show();
      }
    });

    $('#leaving_datepicker').val(data['_leavingDate_formatted']);
    $('[data-target="#leaving_time"]').val(data['_leavingDate_additional']);
    $('#returning_datepicker').val(data['_returnDate_formatted']);
    $('[data-target="#returning_time"]').val(data['_returnDate_additional']);

      // Amendments //
    $('#editReportModal').find('.a_amendments').find('tbody').children().remove();

    for (var auditTrailItemIndex in data['_auditTrail']) {
      var auditTrailRow = $($('.template_modal_amendments_row1').html());

      for (var auditTrailProperty in data['_auditTrail'][auditTrailItemIndex]) {
        auditTrailRow.find('.data_' + auditTrailProperty).each(function(index, element) {
          $(element).html(data['_auditTrail'][auditTrailItemIndex][auditTrailProperty]);
        });
      }

      for (var auditTrailRecordIndex in data['_auditTrail'][auditTrailItemIndex]['_record']) {
        var auditTrailRecord = $($('.template_modal_amendments_row2').html());

        for (var auditTrailProperty in data['_auditTrail'][auditTrailItemIndex]['_record'][auditTrailRecordIndex]) {
          auditTrailRecord.find('.data_' + auditTrailProperty).each(function(index, element) {
            $(element).html(data['_auditTrail'][auditTrailItemIndex]['_record'][auditTrailRecordIndex][auditTrailProperty]);
          });
        }

        auditTrailRow.find('.a_before').after($(auditTrailRecord.find('tr').get(0)));
      }

      $($('#editReportModal').find('.a_amendments').find('tbody').get(0)).append($(auditTrailRow.find('tr').get(0)));
    }

    // Payments //

    $('#editReportModal').find('.a_payments_list').find('tbody').children().remove();

    for (var paymentItemIndex in data['_payment']) {
      var paymentRow = $($('.template_modal_payments_row').html());
      for (var property in data['_payment'][paymentItemIndex]) {
        paymentRow.find('.data_' + property).each(function(index, element) {
          if ($(element).is('input')) {
            $(element).val(data['_payment'][paymentItemIndex][property]);
          } else {
            $(element).html(data['_payment'][paymentItemIndex][property]);
          }
        });
      }

      paymentRow.find('.a-link-setaspaid').on('click', function(event) {
        $.ajax({
          url: '/ajax_payment_setaspaid',
          method: 'post',
          data: { id: $(event.currentTarget).parents('tr').find('.data_id').val() }
        }).done(function(data) {
          $(event.currentTarget).parents('tr').find('.data_status').html(data['status']);
        });
      });

      paymentRow.find('.a-link-delete').on('click', function(event) {
        $.ajax({
          url: '/ajax_payment_delete',
          method: 'post',
          data: { id: $(event.currentTarget).parents('tr').find('.data_id').val() }
        }).done(function(data) {
          $(event.currentTarget).parents('tr').remove();
        });
      });

      $($('#editReportModal').find('.a_payments_list').find('tbody').get(0)).append($(paymentRow.find('tr').get(0)));
    }

    $('#editReportModal .a_payments_add_payment').off('click');

    $('#editReportModal .a_payments_add_payment').on('click', function(event) {
      //var properties = {report: reportId};
      var properties = {report: reportId};
      var invalid = false;

      $('#editReportModal').find('.a_payments_data').each(function(index, element) {
        var classList = $(element).attr('class').split(/\s+/);
        $.each(classList, function(index, item) {
          if (item.indexOf('a_payments_data_property_') === 0) {
            properties[item.substr(25)] = $(element).val();
            invalid = invalid || !element.checkValidity();
               }
             });
        });

           if (!invalid) {
             $.ajax({
               url: '/ajax_payment_add',
               method: 'post',
               data: properties
             }).done(function(data) {
               var paymentRow = $($('.template_modal_payments_row').html());

               for (var property in data['payment']) {
                 paymentRow.find('.data_' + property).each(function(index, element) {
                   if ($(element).is('input')) {
                     $(element).val(data['payment'][property]);
                   } else {
                     $(element).html(data['payment'][property]);
                   }
                 });
               }

               paymentRow.find('.a-link-setaspaid').on('click', function(event) {
                 $.ajax({
                   url: '/ajax_payment_setaspaid',
                   method: 'post',
                   data: { id: $(event.currentTarget).parents('tr').find('.data_id').val() }
                 }).done(function(data) {
                   $(event.currentTarget).parents('tr').find('.data_status').html(data['status']);
                 });
               });

               paymentRow.find('.a-link-delete').on('click', function(event) {
                 $.ajax({
                   url: '/ajax_payment_delete',
                   method: 'post',
                   data: { id: $(event.currentTarget).parents('tr').find('.data_id').val() }
                 }).done(function(data) {
                   $(event.currentTarget).parents('tr').remove();
                 });
               });

               $($('#editReportModal').find('.a_payments_list').find('tbody').get(0)).prepend($(paymentRow.find('tr').get(0)));

               $('#editReportModal').find('.a_payments_data').each(function(index, element) {
                 var classList = $(element).attr('class').split(/\s+/);
                 $.each(classList, function(index, item) {
                   if (item.indexOf('a_payments_data_property_') === 0) {
                     $(element).val('');
                   }
                 });
               });
             });
           }
         });

         $('#editReportModal .button-save').off('click');

         $('#editReportModal .button-save').on('click', function(event) {
           var properties = {report: reportId};
           var invalid = false;

           $('#editReportModal').find('.save-data').each(function(index, element) {
             var classList = $(element).attr('class').split(/\s+/);
             $.each(classList, function(index, item) {
               if (item.indexOf('save-data-property-') === 0) {
                 properties[item.substr(19)] = $(element).val();

                 invalid = invalid || !element.checkValidity();
               }
             });
           });

           properties['leavingDate'] = moment(properties['leavingDate1'] + ' ' + properties['leavingDate2'], 'D/M/YYYY h:m A').format('YYYY-MM-DD HH:mm:ss');
           properties['returnDate'] = moment(properties['returnDate1'] + ' ' + properties['returnDate2'], 'D/M/YYYY h:m A').format('YYYY-MM-DD HH:mm:ss');

           if (!invalid) {
             $('#editReportModal').find('.modal-content > div').each(function(index, element) {
               if ($(element).hasClass('modal-loader')) {
                 $(element).show();
               } else {
                 $(element).hide();
               }
             });

             $.ajax({
               url: '/ajax_report_save',
               method: 'post',
               data: properties
             }).done(function(data) {
               $('#editReportModal').modal('hide');

               refresh();

               $('.alertZone').html($('.alertTemplate').html());

               $('.alertZone').find('.alert').show();

               $('.alertZone').on('click', 'button', function(event) {
                 $('.alertZone').find('.alert').hide('fade');
               });
             });
           }
         });

         $('#editReportModal .button-add').off('click');

         $('#editReportModal .button-add').on('click', function(event) {
          window.location = 'add.php?report=' + reportId;
        });

         $('#editReportModal .button-cancel').off('click');

         $('#editReportModal .button-cancel').on('click', function(event) {
          var properties = {report: reportId};
          var invalid = false;

          $('#editReportModal').find('.cancel-data').each(function(index, element) {
            var classList = $(element).attr('class').split(/\s+/);
            $.each(classList, function(index, item) {
              if (item.indexOf('cancel-data-property-') === 0) {
                properties[item.substr(19)] = $(element).val();

                invalid = invalid || !element.checkValidity();
              }
            });
          });

          if (!invalid) {
            $('#editReportModal').find('.modal-content > div').each(function(index, element) {
              if ($(element).hasClass('modal-loader')) {
                $(element).show();
              } else {
                $(element).hide();
              }
            });

            $.ajax({
              url: 'ajax_report_cancel.php',
              method: 'post',
              data: properties
            }).done(function(data) {
              $('#editReportModal').modal('hide');

              refresh();

              $('.alertZone').html($('.alertTemplate').html());

              $('.alertZone').find('.alert').show();

              $('.alertZone').on('click', 'button', function(event) {
                $('.alertZone').find('.alert').hide('fade');
              });
            });
          }
        });

       });

$('#editReportModal .button-noshow').off('click');

$('#editReportModal .button-noshow').on('click', function(event) {
  var properties = {report: reportId};
  var invalid = false;

  $('#editReportModal').find('.cancel-data').each(function(index, element) {
   var classList = $(element).attr('class').split(/\s+/);
   $.each(classList, function(index, item) {
     if (item.indexOf('cancel-data-property-') === 0) {
       properties[item.substr(19)] = $(element).val();

       invalid = invalid || !element.checkValidity();
     }
   });
 });

  if (!invalid) {
    $('#editReportModal').find('.modal-content > div').each(function(index, element) {
     if ($(element).hasClass('modal-loader')) {
       $(element).show();
     } else {
       $(element).hide();
     }
   });

    $.ajax({
     url: 'ajax_report_noshow.php',
     method: 'post',
     data: properties
   }).done(function(data) {
     $('#editReportModal').modal('hide');

     refresh();

     $('.alertZone').html($('.alertTemplate').html());

     $('.alertZone').find('.alert').show();

     $('.alertZone').on('click', 'button', function(event) {
       $('.alertZone').find('.alert').hide('fade');
     });
   });
 }
});
});
 // shareable

  $('#leaving_datepicker').datetimepicker({
    format: 'DD/MM/YYYY'
  });

  $('#returning_datepicker').datetimepicker({
    format: 'DD/MM/YYYY'
  });

  $('#leaving_time').datetimepicker({
   format: 'HH:mm',
   extraFormats: ['HH:mm']
  });

  $('#returning_time').datetimepicker({
   format: 'HH:mm',
   extraFormats: ['HH:mm']
  });
});