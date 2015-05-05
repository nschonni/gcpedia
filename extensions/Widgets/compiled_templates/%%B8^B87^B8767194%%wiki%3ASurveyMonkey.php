<?php /* Smarty version 2.6.18-dev, created on 2011-06-02 11:47:07
         compiled from wiki:SurveyMonkey */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:SurveyMonkey', 1, false),array('modifier', 'default', 'wiki:SurveyMonkey', 1, false),)), $this); ?>
<iframe src="http://www.surveymonkey.com/s.aspx?sm=<?php echo ((is_array($_tmp=$this->_tpl_vars['sm'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
" width="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['width'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, 300) : smarty_modifier_default($_tmp, 300)); ?>
" height="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['height'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, 400) : smarty_modifier_default($_tmp, 400)); ?>
" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>