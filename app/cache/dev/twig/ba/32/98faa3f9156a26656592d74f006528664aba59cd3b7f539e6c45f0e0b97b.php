<?php

/* WSOvsBundle::layout.html.twig */
class __TwigTemplate_ba3298faa3f9156a26656592d74f006528664aba59cd3b7f539e6c45f0e0b97b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
            'ovs' => array($this, 'block_ovs'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("title", $context, $blocks);
        echo " - ovs
";
    }

    // line 7
    public function block_body($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        $this->displayBlock('ovs', $context, $blocks);
    }

    public function block_ovs($context, array $blocks = array())
    {
        // line 9
        echo "    ";
    }

    public function getTemplateName()
    {
        return "WSOvsBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 9,  43 => 8,  40 => 7,  33 => 4,  30 => 3,  42 => 7,  39 => 6,  32 => 4,  29 => 3,);
    }
}
