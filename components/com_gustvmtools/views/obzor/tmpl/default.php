<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
JHtml::_('behavior.formvalidation');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
// Загружаем тултипы.
?>
  <script>
  jQuery(function($) {
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#filter" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        source: function( request, response ) {
          $.getJSON( "index.php?type=search-obzor&str=" + $('#filter').val(), {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
      });
  });
  </script>
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=obzor'); ?>" method="post" name="adminForm">
<div class="ui-widget">
  <label for="filter">Фильтровать по модели: </label>
  <input id="filter" size="50" name="filter" value="<?php echo $filter?>"/>
</div>
<input type="submit" value="фильтровать">
    <?php echo $this->loadTemplate('head');?>
    <?php echo $this->loadTemplate('body');?>
    <?php echo $this->loadTemplate('foot');?>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="video"/>
<?php echo JHtml::_('form.token'); ?>
</form>