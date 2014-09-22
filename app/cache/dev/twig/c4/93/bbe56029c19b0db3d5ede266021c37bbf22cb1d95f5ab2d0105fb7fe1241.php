<?php

/* WSChatBundle:Chat:voir.html.twig */
class __TwigTemplate_c493bbe56029c19b0db3d5ede266021c37bbf22cb1d95f5ab2d0105fb7fe1241 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("WSChatBundle::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'chat' => array($this, 'block_chat'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "WSChatBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo "    ";
        $this->displayParentBlock("title", $context, $blocks);
        echo " - voir
";
    }

    // line 5
    public function block_chat($context, array $blocks = array())
    {
        // line 6
        echo "    <p>Vue<p>
";
    }

    public function getTemplateName()
    {
        return "WSChatBundle:Chat:voir.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 6,  39 => 5,  32 => 3,  29 => 2,);
    }
}
