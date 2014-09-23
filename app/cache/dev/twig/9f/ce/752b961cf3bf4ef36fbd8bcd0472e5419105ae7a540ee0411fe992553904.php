<?php

/* WSChatBundle:Chat:listUser.html.twig */
class __TwigTemplate_9fce752b961cf3bf4ef36fbd8bcd0472e5419105ae7a540ee0411fe992553904 extends Twig_Template
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
        echo "<ul id=\"userclick\">
";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["users"]) ? $context["users"] : $this->getContext($context, "users")));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 3
            echo "        <li><span>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username"), "html", null, true);
            echo "</span></li>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 5
        echo "</ul>";
    }

    public function getTemplateName()
    {
        return "WSChatBundle:Chat:listUser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 3,  22 => 2,  19 => 1,  150 => 50,  145 => 49,  140 => 6,  134 => 5,  128 => 51,  125 => 50,  123 => 49,  118 => 47,  113 => 45,  106 => 40,  100 => 34,  94 => 31,  88 => 28,  82 => 25,  79 => 24,  74 => 22,  70 => 21,  65 => 19,  60 => 18,  58 => 17,  46 => 11,  35 => 5,  23 => 1,  50 => 12,  43 => 6,  40 => 5,  33 => 6,  30 => 2,  42 => 10,  39 => 5,  32 => 3,  29 => 5,);
    }
}
