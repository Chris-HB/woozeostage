<?php

/* WSOvsBundle:Sport:add.html.twig */
class __TwigTemplate_7f0d50ee93a9c9942a88ce9e48d799f4cc18cd603d6cbeb125e21d8b59242342 extends Twig_Template
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
        echo " - ajouter sport
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
        return "WSOvsBundle:Sport:add.html.twig";
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
