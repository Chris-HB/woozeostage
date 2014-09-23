<?php

/* WSOvsBundle:Date:list.html.twig */
class __TwigTemplate_76f071d0f9f36ff2ecbdad5d62e06a9c26c5fb274e5f670fe43c922de2a8e7ea extends Twig_Template
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
        echo " - list date
";
    }

    // line 6
    public function block_ovs($context, array $blocks = array())
    {
        // line 7
        echo "    ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["dates"]) ? $context["dates"] : $this->getContext($context, "dates")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["date"]) {
            // line 8
            echo "        <p>";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["date"]) ? $context["date"] : $this->getContext($context, "date")), "date"), "d/m/Y"), "html", null, true);
            echo "</p>
    ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 10
            echo "        <p>Pas encore de date</p>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['date'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "WSOvsBundle:Date:list.html.twig";
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
