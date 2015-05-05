<?php /* Smarty version 2.6.18-dev, created on 2015-04-23 14:08:35
         compiled from wiki:LinkedIn+Profile */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'validate', 'wiki:LinkedIn Profile', 2, false),array('modifier', 'escape', 'wiki:LinkedIn Profile', 2, false),)), $this); ?>
<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/MemberProfile" data-id="<?php echo ((is_array($_tmp=$this->_tpl_vars['profile'])) ? $this->_run_mod_handler('validate', true, $_tmp, 'url') : smarty_modifier_validate($_tmp, 'url')); ?>
" data-format="<?php if (isset ( $this->_tpl_vars['popup'] )): ?>hover<?php else: ?>inline<?php endif; ?>" data-text="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"></script>

[[Category:Widget]]