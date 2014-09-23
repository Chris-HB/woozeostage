<?php

/* WSOvsBundle:Sport:list.html.twig */
class __TwigTemplate_3804eb8a60467c9b48751af5727a0e0cf79ed5ae8e9c0ff1cc69938936931165 extends Twig_Template
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
        echo " - list sport
";
    }

    // line 6
    public function block_ovs($context, array $blocks = array())
    {
        // line 7
        echo "    ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["sports"]) ? $context["sports"] : $this->getContext($context, "sports")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["sport"]) {
            // line 8
            echo "        <p>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sport"]) ? $context["sport"] : $this->getContext($context, "sport")), "nom"), "html", null, true);
            echo "</p>
    ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 10
            echo "        <p>Pas encore de sport</p>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sport'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "WSOvsBundle:Sport:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 10,  48 => 8,  42 => 7,  39 => 6,  32 => 4,  29 => 3,);
    }
}
