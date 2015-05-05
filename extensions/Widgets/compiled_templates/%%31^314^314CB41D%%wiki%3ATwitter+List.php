<?php /* Smarty version 2.6.18-dev, created on 2015-04-23 14:17:47
         compiled from wiki:Twitter+List */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:Twitter List', 3, false),array('modifier', 'default', 'wiki:Twitter List', 3, false),)), $this); ?>

<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script> new TWTR.Widget({  version: 2,  type: 'list',  rpp: 30,  interval: 6000,  title: '<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
',  subject: '<?php echo ((is_array($_tmp=$this->_tpl_vars['subject'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
',  width: '<?php echo ((is_array($_tmp=$this->_tpl_vars['width'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
',  height: <?php echo ((is_array($_tmp=$this->_tpl_vars['height'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
,  theme: {    shell: {      background: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['shell']['background'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#ffffff') : smarty_modifier_default($_tmp, '#ffffff')); ?>
',      color: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['shell']['color'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#267811') : smarty_modifier_default($_tmp, '#267811')); ?>
'    },    tweets: {      background: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tweets']['background'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#ffffff') : smarty_modifier_default($_tmp, '#ffffff')); ?>
',      color: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tweets']['color'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#050005') : smarty_modifier_default($_tmp, '#050005')); ?>
',      links: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tweets']['links'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('default', true, $_tmp, '#407fc2') : smarty_modifier_default($_tmp, '#407fc2')); ?>
'    }  },  features: {    scrollbar: true,    loop: false,    live: true,    hashtags: true,    timestamp: true,    avatars: true,    behavior: 'all'  } }).render().setList('<?php echo ((is_array($_tmp=$this->_tpl_vars['user'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
', '<?php echo ((is_array($_tmp=$this->_tpl_vars['list'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
').start(); </script>

[[Category:Widget]]