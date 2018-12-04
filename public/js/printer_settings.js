// Make the DIV element draggable:
dragElement(document.getElementById("mydiv"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV: 
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}

(function($) {
  $.fn.toMillimeters = function() {
    var element = this,
    top = parseInt(element.css('top')),
    left = parseInt(element.css('left')),
    millimeters = {};
    millimeters.top = Math.floor(top * 0.264583);
    millimeters.left = Math.floor(left * 0.264583);
    return millimeters;
  };
})(jQuery);

$(document).ready(function(){
  $(document).on('click', '.box_papper div', function() {
    $('.selected_item').removeClass('selected_item');
    var clone_item = $(this).clone();
    clone_item.addClass('selected_item');
    clone_item.addClass('cloned_item_'+$(this).attr('id'));
    $('#item_selected').val($(this).attr('id'));
    $(this).css({opacity: '.5'});
    $('.box_papper').append(clone_item);
  })

  $(document).on('click', '.arrow_direction', function() {
    var direction = $(this).data('direction');
    var item = $('#item_selected').val();
    if(item != ''){
      var item_cloned = $('.cloned_item_'+item);
      var item_cloned_position = $('.cloned_item_'+item).toMillimeters();
      var new_top = item_cloned_position.top +1;
      var new_left = item_cloned_position.left +1;
      if(direction == 'up'){
        new_top--;
        item_cloned.css({top: new_top+'mm'})
      }else if(direction == 'left'){
        new_left--;
        item_cloned.css({left: new_left+'mm'})
      }else if(direction == 'down'){
        new_top++;
        item_cloned.css({top: new_top+'mm'})
      }else if(direction == 'right'){
        new_left++;
        item_cloned.css({left: new_left+'mm'})
      }
      var new_position = 'left:'+new_left+'mm;top:'+new_top+'mm;';
      $( "input[name='"+item+"']" ).val(new_position);
    }
  })

  $(document).on('click', '.save_printer_settings', function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var form = $('#save_position_form');
    $.ajax({
      url: $(form).attr('action'),
      type:'POST',
      data: $(form).serialize(),
    }).done(function(data) {
      window.location.reload();
    });
  })

})
