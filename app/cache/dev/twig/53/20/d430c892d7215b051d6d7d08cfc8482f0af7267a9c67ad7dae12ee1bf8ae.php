<?php

/* WSOvsBundle:Date:add.html.twig */
class __TwigTemplate_5320d430c892d7215b051d6d7d08cfc8482f0af7267a9c67ad7dae12ee1bf8ae extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("WSOvsBundle::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'ovs' => array($this, 'block_ovs'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "WSOvsBundle::layout.html.twig";
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
        echo " - ajouter date
";
    }

    // line 6
    public function block_ovs($context, array $blocks = array())
    {
        // line 7
        echo "    ";
        $this->env->loadTemplate("WSOvsBundle:formulaire:formulaire.html.twig")->display($context);
    }

    public function getTemplateName()
    {
        return "WSOvsBundle:Date:add.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 7,  39 => 6,  32 => 4,  29 => 3,);
    }
}
