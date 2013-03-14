<?
only_admin_access();
$data = get_notifications('order_by=created_on desc');
 

?>


<script  type="text/javascript">
mw.notif_item_delete = function($item_id){


	 $.get("<?php print site_url('api/delete_notification'); ?>/"+$item_id, function(){
		 	mw.$('.mw-ui-admin-notif-item-'+$item_id).fadeOut();
 
	  });
}
</script>
<? if(isarr($data )): ?>

<div class="mw-admin-notifications-holder">
  <table cellspacing="0" cellpadding="0" class="mw-ui-admin-table">
    <tbody>
      <? foreach($data  as $item): ?>
      <tr class="mw-ui-admin-notif-item-<? print $item['id'] ?> <? if(isset($item['is_read']) and trim( $item['is_read']) == 'n'): ?>mw-success<? endif; ?>">
        <td><date><? print mw_date($item['created_on']); ?></date>
        <br />

           <time><? print ago($item['created_on'],1); ?></time>
        </td>
          
        <td><?
	 $mod_info = false;
	 if(isset($item['module']) and $item['module'] != ''){
		 $mod_info = module_info($item['module']);
		}
?>
        
        
          <? if($mod_info != false and isset($mod_info['name'])): ?>
         
          
          
          <a class="mw-ui-link" href="<? print admin_url() ?>view:modules/load_module:<? print module_name_encode($item['module']) ?>/mw_notif:<? print $item['id'] ?>" title="<? print $mod_info['name'] ?>"> <img src=" <?   print thumbnail($mod_info['icon'], 16,16) ?>" /><? print $item['title'] ?></a>
          <? else : ?>
          <? print $item['title'] ?>
          <? endif; ?></td>
        <td>
        <a href="<? if($mod_info != false and isset($mod_info['name'])): ?><? print admin_url() ?>view:modules/load_module:<? print module_name_encode($item['module']) ?>/mw_notif:<?  print  $item['id'] ?><? endif; ?>" class="mw-ui-btn-rect">
		<? if(isset($item['content']) and $item['content'] != ''): ?>
          <small><? print $item['content']; ?></small>
          <? else : ?>
          <? endif; ?>
          </a>
          </td>
        <td><a href="javascript:mw.notif_item_delete('<? print $item['id'] ?>');" class="mw-ui-admin-table-show-on-hover mw-ui-btn">x</a></td>
      </tr>
      <? endforeach ; ?>
    </tbody>
  </table>
</div>
<? endif; ?>
