<?php /* Smarty version 2.6.18-dev, created on 2015-04-23 14:10:29
         compiled from wiki:Twitter+Follow */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:Twitter Follow', 1, false),)), $this); ?>
<a href="http://www.twitter.com/<?php echo ((is_array($_tmp=$this->_tpl_vars['twitter'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
"><img src="http://twitter-badges.s3.amazonaws.com/follow_<?php echo ((is_array($_tmp=$this->_tpl_vars['what'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
-a.png" alt="Follow <?php echo ((is_array($_tmp=$this->_tpl_vars['twitter'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
 on Twitter"/></a>

[[Category:Widget]]