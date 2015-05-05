<?php /* Smarty version 2.6.18-dev, created on 2015-04-23 14:11:23
         compiled from wiki:Twitter */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'wiki:Twitter', 1, false),array('modifier', 'escape', 'wiki:Twitter', 6, false),array('modifier', 'default', 'wiki:Twitter', 6, false),array('modifier', 'validate', 'wiki:Twitter', 8, false),)), $this); ?>
<?php echo smarty_function_counter(array('name' => 'twittercounter','assign' => 'twitblogincluded'), $this);?>
<?php if ($this->_tpl_vars['twitblogincluded'] == 1): ?><script src="http://widgets.twimg.com/j/2/widget.js"></script><?php endif; ?>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['count'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, 5) : smarty_modifier_default($_tmp, 5)); ?>
',
  interval: 6000,
  width: <?php if ($this->_tpl_vars['width'] == 'auto'): ?>'auto'<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['width'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, 250) : smarty_modifier_default($_tmp, 250)))) ? $this->_run_mod_handler('validate', true, $_tmp, 'int') : smarty_modifier_validate($_tmp, 'int')); ?>
<?php endif; ?>,
  height: <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['height'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, 300) : smarty_modifier_default($_tmp, 300)))) ? $this->_run_mod_handler('validate', true, $_tmp, 'int') : smarty_modifier_validate($_tmp, 'int')); ?>
,
  theme: {
    shell: {
      background: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['shell']['background'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#333333') : smarty_modifier_default($_tmp, '#333333')); ?>
',
      color: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['shell']['color'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#ffffff') : smarty_modifier_default($_tmp, '#ffffff')); ?>
'
    },
    tweets: {
      background: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tweets']['background'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#000000') : smarty_modifier_default($_tmp, '#000000')); ?>
',
      color: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tweets']['color'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#ffffff') : smarty_modifier_default($_tmp, '#ffffff')); ?>
',
      links: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tweets']['links'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#4aed05') : smarty_modifier_default($_tmp, '#4aed05')); ?>
'
    }
  },
  features: {
    scrollbar: <?php if (isset ( $this->_tpl_vars['scrollbar'] )): ?>true<?php else: ?>false<?php endif; ?>,
    loop: false,
    live: <?php if (isset ( $this->_tpl_vars['poll'] )): ?>true<?php else: ?>false<?php endif; ?>,
    hashtags: true,
    timestamp: true,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('<?php echo ((is_array($_tmp=$this->_tpl_vars['user'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
').start();
</script>