<?php

/* WSOvsBundle:formulaire:formulaire.html.twig */
class __TwigTemplate_f7df6e8189a026bfdc26cb4dcaca30631cabc6c4bf23035972096690eb35884d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo " <div class='formulaire'>
    <form method=\"post\" ";
        // line 2
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'enctype');
        echo ">
        ";
        // line 3
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'widget');
        echo "
        <input type=\"submit\" class=\"btn btn-primary\" />
    </form>
</div>";
    }

    public function getTemplateName()
    {
        return "WSOvsBundle:formulaire:formulaire.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 3,  22 => 2,  19 => 1,  156 => 50,  151 => 49,  146 => 6,  140 => 5,  134 => 51,  131 => 50,  129 => 49,  124 => 47,  119 => 45,  110 => 39,  106 => 38,  100 => 34,  94 => 31,  88 => 28,  82 => 25,  79 => 24,  74 => 22,  70 => 21,  65 => 19,  60 => 18,  58 => 17,  46 => 11,  35 => 7,  23 => 1,  50 => 12,  43 => 8,  40 => 7,  33 => 6,  30 => 3,  42 => 10,  39 => 6,  32 => 4,  29 => 5,);
    }
}
