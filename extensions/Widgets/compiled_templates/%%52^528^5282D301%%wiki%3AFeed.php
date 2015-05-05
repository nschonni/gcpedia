<?php /* Smarty version 2.6.18-dev, created on 2011-05-24 13:44:20
         compiled from wiki:Feed */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:Feed', 1, false),)), $this); ?>
<script language="JavaScript" src="http://feed2js.org//feed2js.php?src=<?php echo ((is_array($_tmp=$this->_tpl_vars['feedurl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
&amp;chan=<?php echo ((is_array($_tmp=$this->_tpl_vars['chan'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
&amp;num=<?php echo ((is_array($_tmp=$this->_tpl_vars['num'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
&amp;desc=<?php echo ((is_array($_tmp=$this->_tpl_vars['desc'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
&amp;date=<?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
&amp;targ=<?php echo ((is_array($_tmp=$this->_tpl_vars['targ'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
&amp;utf=y" type="text/javascript"></script>