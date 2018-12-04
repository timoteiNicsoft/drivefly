$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(chartLoadedCallback);

     var chartLoaded = false;

     function chartLoadedCallback() {
       chartLoaded = true;
     }
Dropzone.autoDiscover = false;

var myDropzone = null;
var reportId = 0;

$(document).ready(function() {

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
         case 'Amended': $(element).addClass('badge-success'); $(element).removeClass('badge-warning badge-danger'); break;
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

         // Amendments
         //

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

         // Payments
         //

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
           var properties = {report: reportId}
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
           var properties = {};
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
       });
});

$('#leaving_datepicker').datetimepicker({
 format: 'DD/MM/YYYY'
});

$('#returning_datepicker').datetimepicker({
 format: 'DD/MM/YYYY'
});

$('#leaving_time').datetimepicker({
 format: 'LT'
});

$('#returning_time').datetimepicker({
 format: 'LT'
});
});

request = {
     service: '0',
     airport: '0',
     date_from: '',
     date_to: '',
     terminal: '0'
   };

   var inCall = false;

   var chartData = [];

   function showChart()
   {
     if (!chartLoaded) {
       setTimeout('showChart()', 500);

       return;
     }

     var data = google.visualization.arrayToDataTable(chartData);


     var options = {
       isStacked: true,
       width: '100%',
       height: 600,
       hAxis: {
         title: 'Days',
       },
       vAxis: {
         title: 'Count'
       },
       series: {
         0: {
           color: 'rgb(82, 186, 225)'
         },
         1: {
           color: 'rgb(18, 194, 100)'
         },
         2: {
           color: 'rgb(154, 82, 2)'
         },
         3: {
           color: 'rgb(246, 171, 47)'
         },
         4: {
           color: 'rgb(139, 92, 157)'
         },
         5: {
           color: 'rgb(184, 190, 193)'
         },
         6: {
           color: 'rgb(254, 179, 56)'
         },
         7: {
           color: 'rgb(243, 87, 156)'
         },
         8: {
           color: 'rgb(153, 51, 204)'
         },
         9: {
           color: 'rgb(255, 111, 24)'
         },
         10: {
           color: 'rgb(184, 190, 193)'
         },
         11: {
           color: 'rgb(184, 190, 193)'
         },
         12: {
           color: 'rgb(184, 190, 193)'
         }
       }
     };


     var chart = new google.charts.Bar(document.getElementById('chart_div'));

     chart.draw(data, google.charts.Bar.convertOptions(options));
   }

   function refresh()
   {
     if (inCall) {
       return;
     }

     inCall = true;

     $('.a_container').html($('.loader_container').html());

     $.ajax({
       url: '/ajax_stats',
       method: 'post',
       data: request
     }).done(function(data) {
       var list = $($('.list_template').html());

       chartData = [];

       var head = false;

       for (var dataIndex in data) {
         var listEntry = $($('.list_item_template').html());

         if (!head) {
           for (var date in data[dataIndex]['data']) {
             list.find('.a_tr').append($('<table><thead><th>' + date + '</th></thead></table>').find('th')[0]);
           }

           var row = ['Days'];
           for (var dataIndexHead in data) {
             row.push(data[dataIndexHead]['acronym']);
           }
           row.push({ role: 'annotation' });
           chartData.push(row);

           head = true;
         }

         var item = '<td>' + data[dataIndex]['acronym'] + '</td>';
         var index = 1;
         for (var date in data[dataIndex]['data']) {
           item += '<td>' + data[dataIndex]['data'][date] + '</td>';

           if (!chartData[index]) {
             chartData[index] = [date];
           }

           chartData[index].push(parseInt(data[dataIndex]['data'][date]));

           index++;
         }

         list.find('.a_tbody').append($('<table><tbody><tr>' + item + '</tr></tbody></table>').find('tr')[0]);
       }

       $('.a_container').html('');
       $('.a_container').append(list);

       var index = 0;
       for (var row in chartData) {
         if (index) {
           chartData[row].push('');
         }

         index++;
       }

       showChart();

       inCall = false;
     });
   }

   $(document).ready(function() {
     $('.property_refresh_check').on('change', function(event) {
       var classList = $(event.currentTarget).attr('class').split(/\s+/);
       $.each(classList, function(index, item) {
         if (item.indexOf('property_name_') === 0) {
           request[item.substr(14)] = $(event.currentTarget).attr('value');
         }
       });

       refresh();
     });

     $('#datetimepicker_from').datetimepicker({
       defaultDate: moment(new Date()).subtract(13, 'day').format('YYYY-MM-DD'),
       format: 'DD/MM/YYYY'
     });

     $('#datetimepicker_to').datetimepicker({
       defaultDate: moment(new Date()).format('YYYY-MM-DD'),
       format: 'DD/MM/YYYY'
     });

     request['date_from'] = moment(new Date()).subtract(13, 'day').format('YYYY-MM-DD');

     request['date_to'] = moment(new Date()).format('YYYY-MM-DD');

     $("#datetimepicker_from").on("change.datetimepicker", function (e) {
       $('#datetimepicker_to').datetimepicker('minDate', e.date);

       request['date_from'] = moment($('#datetimepicker_from').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');

       refresh();
     });

     $("#datetimepicker_to").on("change.datetimepicker", function (e) {
       $('#datetimepicker_from').datetimepicker('maxDate', e.date);

       request['date_to'] = moment($('#datetimepicker_to').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');

       refresh();
     });

     refresh();
   });