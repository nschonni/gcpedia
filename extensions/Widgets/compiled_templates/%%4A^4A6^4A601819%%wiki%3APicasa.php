<?php /* Smarty version 2.6.18-dev, created on 2015-04-23 14:08:35
         compiled from wiki:Picasa */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'wiki:Picasa', 1, false),array('modifier', 'escape', 'wiki:Picasa', 1, false),)), $this); ?>
<embed type="application/x-shockwave-flash" src="http://picasaweb.google.com/s/c/bin/slideshow.swf" width="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['width'])) ? $this->_run_mod_handler('default', true, $_tmp, 600) : smarty_modifier_default($_tmp, 600)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" height="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['height'])) ? $this->_run_mod_handler('default', true, $_tmp, 400) : smarty_modifier_default($_tmp, 400)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" flashvars="host=picasaweb.google.com<?php if (isset ( $this->_tpl_vars['captions'] ) && $this->_tpl_vars['captions']): ?>&captions=1<?php endif; ?><?php if (! isset ( $this->_tpl_vars['autoplay'] ) || ! $this->_tpl_vars['autoplay']): ?>&noautoplay=1<?php endif; ?>&interval=<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['interval'])) ? $this->_run_mod_handler('default', true, $_tmp, 60) : smarty_modifier_default($_tmp, 60)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&RGB=0x000000&feed=http%3A%2F%2Fpicasaweb.google.com%2Fdata%2Ffeed%2Fapi%2Fuser%2F<?php echo ((is_array($_tmp=$this->_tpl_vars['user'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
%2Falbumid%2F<?php echo ((is_array($_tmp=$this->_tpl_vars['album'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
%3Fkind%3Dphoto%26alt%3Drss<?php if (isset ( $this->_tpl_vars['authkey'] ) && $this->_tpl_vars['authkey']): ?>%26authkey%3D<?php echo ((is_array($_tmp=$this->_tpl_vars['authkey'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
<?php endif; ?>" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>

[[Category:Widget]]