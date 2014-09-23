<?php

/* WSChatBundle:Chat:listUser.html.twig */
class __TwigTemplate_231832a7e834bbf332705b3890dbbc8586e4c8747cf76abdc3f47762e293b013 extends Twig_Template
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
        return array (  26 => 3,  22 => 2,  19 => 1,  144 => 44,  139 => 43,  134 => 6,  128 => 5,  122 => 45,  119 => 44,  117 => 43,  112 => 41,  107 => 39,  100 => 34,  94 => 31,  88 => 28,  82 => 25,  79 => 24,  74 => 22,  70 => 21,  65 => 19,  60 => 18,  58 => 17,  46 => 11,  35 => 5,  23 => 1,  50 => 12,  43 => 6,  40 => 5,  33 => 6,  30 => 2,  42 => 10,  39 => 5,  32 => 3,  29 => 5,);
    }
}
