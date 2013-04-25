<?php
/**
 * @package     Windwalker.Framework
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.html.html');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list for target items.
 *
 * @package     Windwalker.Framework
 * @subpackage  Form
 */
class JFormFieldItemlist extends JFormFieldList
{
    /**
     * The form field type.
     *
     * @var        string
     */
    public $type = 'Itemlist';
    
    /**
     * The value of the form field.
     *
     * @var    mixed 
     */
    public $value ;
    
    /**
     * The name of the form field.
     *
     * @var    string
     */
    public $name ; 
    
    /**
     * List name.
     *
     * @var string 
     */
    protected $view_list ;
    
    /**
     * Item name.
     *
     * @var string 
     */
    protected $view_item ;
    
    /**
     * Extension name, eg: com_content.
     *
     * @var string 
     */
    protected $extension ;
    
    /**
     * Component name without ext type, eg: content.
     *
     * @var string 
     */
    protected $component ;
    
    
    /**
     * Method to get the list of files for the field options.
     * Specify the target directory with a directory attribute
     * Attributes allow an exclude mask and stripping of extensions from file name.
     * Default attribute may optionally be set to null (no file) or -1 (use a default).
     *
     * @return  array  The field option objects.
     */
    public function getOptions()
    {
        // Initialise variables.
        // ========================================================================
        $this->setElement();
        $options    = array();
        $name       = (string) $this->element['name'];
        $show_root  = (string) $this->element['show_root'];
        $published  = (string) $this->element['published'] ;
        $nested     = (string) $this->element['nested'] ;
        $key_field  = $this->element['key_field']     ? (string) $this->element['key_field']         : 'id';
        $value_field= $this->element['value_field'] ? (string) $this->element['value_field']     : 'title';
        $select     = $this->element['select'] ;
        $db         = JFactory::getDbo();
        $q          = $db->getQuery(true) ;
        
        
        
        // Avoid self
        // ========================================================================
        $id     = JRequest::getVar('id') ;
        $option = JRequest::getVar('option') ;
        $view   = JRequest::getVar('view') ;
        $layout = JRequest::getVar('layout') ;
        
        if($nested){
            $table = JTable::getInstance($this->view_item, ucfirst($this->component).'Table');
            $table->load($id) ;
            $q->where("id != {$id}") ;
            $q->where("lft < {$table->lft} OR rgt > {$table->rgt}") ;
        }
        
        
        // Some filter
        // ========================================================================
        if($published) {
            $q->where('published >= 1');
        }
        
        $order = $nested ? 'lft, ordering' : 'ordering' ;
        
        
        // Query
        // ========================================================================
        $select = $select ? '*, ' . $select : '*' ;
        
        $q->select($select)
            ->from('#__' . $this->component.'_'. $this->view_list )
            ->order($order)
            ;
        
        $db->setQuery($q);
        $items = $db->loadObjectList();
        
        $items = $items ? $items : array() ;
        
        
        
        // Set Options
        // ========================================================================
        foreach( $items as $item ):
            $item   = new JObject($item);
            $level  = !empty($item->level) && $nested ? $item->level : 0 ;
            $options[] = JHtml::_('select.option', $item->$key_field, str_repeat('- ', $level).$item->$value_field );
        endforeach;
        
        
        
        // Verify permissions.  If the action attribute is set, then we scan the options.
        // ========================================================================
        if ((string) $this->element['action'] || (string) $this->element['access'])
        {
            
            // Get the current user object.
            $user = JFactory::getUser();

            // For new items we want a list of categories you are allowed to create in.
            if (!$this->value)
            {
                foreach ($options as $i => $option) {
                    // To take save or create in a category you need to have create rights for that category
                    // unless the item is already in that category.
                    // Unset the option if the user isn't authorised for it. In this field assets are always categories.
                    if ($user->authorise('core.create', $this->extension  . '.' . $this->view_item . '.' . $option->value) != true )
                    {
                        unset($options[$i]);
                    }
                }
            }
            // If you have an existing category id things are more complex.
            else
            {
                $value = $this->value;
                foreach ($options as $i => $option)
                {
                    // If you are only allowed to edit in this category but not edit.state, you should not get any
                    // option to change the category.
                    if ($user->authorise('core.edit.own', $this->extension  . '.' . $this->view_item . '.' . $value) != true)
                    {
                        if ($option->value != $value)
                        {
                            unset($options[$i]);
                        }
                    }
                    // However, if you can edit.state you can also move this to another category for which you have
                    // create permission and you should also still be able to save in the current category.
                    elseif
                        (($user->authorise('core.create', $this->extension  . '.' . $this->view_item . '.' . $option->value) != true)
                        && $option->value != $value)
                    {
                        unset($options[$i]);
                    }
                }
            }
        }
        
        
        
        // show root
        // ========================================================================
        if ((string) isset($this->element['show_root']))
        {
            array_unshift($options, JHtml::_('select.option', 1, JText::_('JGLOBAL_ROOT')));
        }
        
        
        
        // Merge any additional options in the XML definition.
        // ========================================================================
        $options = array_merge(parent::getOptions(), $options);
        
        
        
        return $options;
    }
    
    /**
     * Set some element attributes to class variable.  
     */
    public function setElement()
    {
        $view_item = (string) $this->element['view_item'] ;
        $view_list = (string) $this->element['view_list'] ;
        $extension = (string) $this->element['extension'] ;
        
        if(!empty($view_item)){
            $this->view_item = $view_item ;
        }
        
        if(!empty($view_list)){
            $this->view_list = $view_list ;
        }
        
        if(!empty($extension)){
            $this->extension = $extension ;
        }
        
        $this->component = str_replace('com_', '', $this->extension );
    }
}