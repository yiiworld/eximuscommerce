<?php
/**
 * Render form using jquery tabs.
 * @package Widgets
 */
class STabbedForm extends CForm {
	
	public $tabs = array();

    /**
     * @var array Additional tabs to render.
     */
    public $additionalTabs = array();

    /**
     * @var string Widget to render form. zii.widgets.jui.CJuiTabs
     */
    public $formWidget = 'ext.sidebartabs.SAdminSidebarTabs';

	protected $activeTab = null;

	/**
	 * @var boolean Dipslay errors summary on each tab.
	 */
	public $summaryOnEachTab = true;

	public function render()
	{
		$result = $this->renderBegin(); 
		$result .= $this->renderElements();
		$result .= $this->renderEnd();

		return $result;
	}

	public function asTabs()
	{
     	$this->render();
		$result = $this->renderBegin();
		 
		if($this->showErrorSummary && ($model=$this->getModel(false))!==null)
		{
			// Display errors summary on each tab.
			$errorSummary = $this->getActiveFormWidget()->errorSummary($model)."\n";

			if ($this->summaryOnEachTab === true)
			{
				foreach ($this->tabs as &$tab)
					$tab = $errorSummary.$tab;
			}
			else
				$result .= $errorSummary;
		}

		$result .= $this->owner->widget($this->formWidget, array(
			'tabs'=>CMap::mergeArray($this->tabs, $this->additionalTabs),
		), true);	
			
		$result .= $this->renderEnd();
		
		return $result; 
	}

    /**
     * Renders elements
     * @return string
     */
	public function renderElements()
	{
		$output='';
		foreach($this->getElements() as $element)
		{
			if (isset($element->title))
				$this->activeTab = $element->title;

			$out=$this->renderElement($element);

			$this->tabs[$this->activeTab] = $out;

			$output .= $out;
		}
		return $output;
	}


}