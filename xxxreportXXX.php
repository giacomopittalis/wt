
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>
$('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });
});
     </script>
 <form role="form" action="/wohoo" method="POST">
  <label>Stuff</label>
    <div class="multi-field-wrapper">
      <div class="multi-fields">
        <div class="multi-field">
          <input type="text" name="stuff[]">
          <button type="button" class="remove-field">Remove</button>
        </div>
      </div>
    <button type="button" class="add-field">Add field</button>
  </div>
</form><script>
$('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });
});