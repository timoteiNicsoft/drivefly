$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    $('.a_search_close').on('click', function(e) {
        $('.a_search_container').hide();
    });

    $(document).on('click', '#filter_search .dropdown-item', function() {
        var text = $(this).text();
        var data = $(this).data('val');
        $('#search_filter').val(data).change();
        $('.text_selected_filter').text(text);
    })

    $('.trigger_search').on('click', function(e) {
        $.ajax({
            url: '/ajax_search',
            method: 'post',
            data: {
                search: $('.data_search').val(),
                filter: $('#search_filter').val()
            }
        }).done(function(data) {
            $('.a_table_search').find('tbody').html('');

            for (var reportIndex in data) {
                var item = $($('.template_search').html());

                for (var reportProperty in data[reportIndex]) {
                    item.find('.data_' + reportProperty).each(function(index, element) {
                        $(element).html(data[reportIndex][reportProperty]);
                    });
                }

                item.find('.data_color_selector_status').each(function(index, element) {
                    switch (data[reportIndex]['status']) {
                        case 'Ok':
                            $(element).addClass('badge-success');
                            break;
                        case 'Paid':
                            $(element).addClass('badge-success');
                            break;
                        case 'Amended':
                            $(element).addClass('badge-success');
                            break;
                        case 'Booked':
                            $(element).addClass('badge-success');
                            break;
                        case 'Active':
                            $(element).addClass('badge-success');
                            break;
                        case 'Pending':
                            $(element).addClass('badge-warning');
                            break;
                        case 'Cancelled':
                            $(element).addClass('badge-danger');
                            break;
                        case 'CANCEL':
                            $(element).addClass('badge-danger');
                            break;
                        default:
                            $(element).addClass('badge-neutral');
                    }
                });

                item.find('tr').attr('data-report-id', data[reportIndex]['id']);

                $('.a_table_search').find('tbody').append(item.find('tr'));
            }

            $('.a_search_container').show();
        });
    });
});