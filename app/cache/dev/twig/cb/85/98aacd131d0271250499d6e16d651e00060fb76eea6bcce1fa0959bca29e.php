<?php

/* WSChatBundle:Chat:index.html.twig */
class __TwigTemplate_cb8598aacd131d0271250499d6e16d651e00060fb76eea6bcce1fa0959bca29e extends Twig_Template
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
        echo " - index
";
    }

    // line 5
    public function block_chat($context, array $blocks = array())
    {
        // line 6
        echo "    <p>Vive bob<p>
";
    }

    public function getTemplateName()
    {
        return "WSChatBundle:Chat:index.html.twig";
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
