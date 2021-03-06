<?php

namespace Barryvdh\Debugbar\DataCollector;

use Barryvdh\Debugbar\DataCollector\Util\ValueExporter;
use DebugBar\Bridge\Twig\TwigCollector;
use Illuminate\View\View;

class ViewCollector extends TwigCollector
{
    protected $templates = array();
    protected $collect_data;

    /**
     * Create a ViewCollector
     *
     * @param bool $collectData Collects view data when tru
     */
    public function __construct($collectData = true)
    {
        $this->collect_data = $collectData;
        $this->name = 'views';
        $this->templates = array();
        $this->exporter = new ValueExporter();
    }

    public function getName()
    {
        return 'views';
    }

    public function getWidgets()
    {
        return array(
            'views' => array(
                'icon' => 'leaf',
                'widget' => 'PhpDebugBar.Widgets.TemplatesWidget',
                'map' => 'views',
                'default' => '[]'
            ),
            'views:badge' => array(
                'map' => 'views.nb_templates',
                'default' => 0
            )
        );
    }

    /**
     * Add a View instance to the Collector
     *
     * @param \Illuminate\View\View $view
     */
    public function addView(View $view)
    {
        $name = $view->getName();
        $type = pathinfo($view->getPath(), PATHINFO_EXTENSION);

        if (!$this->collect_data) {
            $params = array_keys($view->getData());
        } else {
            $data = array();
            foreach ($view->getData() as $key => $value) {
                if (is_object($value) && method_exists($value, 'toArray')) {
                    $value = $value->toArray();
                }
                $data[$key] = $this->exporter->exportValue($value);
            }
            $params = $data;
        }
        $this->templates[] = array(
            'name' => $name,
            'param_count' => count($params),
            'params' => $params,
            'type' => $type,
        );
    }

    public function collect()
    {
        $templates = $this->templates;

        return array(
            'nb_templates' => count($templates),
            'templates' => $templates,
        );
    }
}
