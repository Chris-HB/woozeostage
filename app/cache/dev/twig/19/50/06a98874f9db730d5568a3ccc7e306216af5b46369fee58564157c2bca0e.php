<?php

/* TwigBundle:Exception:trace.txt.twig */
class __TwigTemplate_195006a98874f9db730d5568a3ccc7e306216af5b46369fee58564157c2bca0e extends Twig_Template
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
        if ($this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "function")) {
            // line 2
            echo "    at ";
            echo (($this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "class") . $this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "type")) . $this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "function"));
            echo "(";
            echo $this->env->getExtension('code')->formatArgsAsText($this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "args"));
            echo ")
";
        } else {
            // line 4
            echo "    at n/a
";
        }
        // line 6
        if (($this->getAttribute((isset($context["trace"]) ? $context["trace"] : null), "file", array(), "any", true, true) && $this->getAttribute((isset($context["trace"]) ? $context["trace"] : null), "line", array(), "any", true, true))) {
            // line 7
            echo "        in ";
            echo $this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "file");
            echo " line ";
            echo $this->getAttribute((isset($context["trace"]) ? $context["trace"] : $this->getContext($context, "trace")), "line");
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:trace.txt.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 13,  26 => 5,  87 => 20,  55 => 13,  31 => 5,  25 => 3,  21 => 2,  92 => 21,  89 => 20,  85 => 19,  75 => 17,  72 => 16,  68 => 14,  64 => 12,  56 => 9,  41 => 9,  24 => 4,  201 => 92,  199 => 91,  196 => 90,  187 => 84,  183 => 82,  173 => 74,  171 => 73,  168 => 72,  166 => 71,  163 => 70,  158 => 67,  156 => 66,  151 => 63,  142 => 59,  138 => 57,  136 => 56,  133 => 55,  123 => 47,  121 => 46,  115 => 43,  105 => 40,  101 => 24,  91 => 31,  86 => 28,  69 => 25,  66 => 15,  62 => 23,  51 => 15,  49 => 19,  19 => 1,  98 => 40,  93 => 9,  80 => 19,  78 => 40,  44 => 10,  36 => 7,  27 => 4,  22 => 2,  57 => 16,  54 => 21,  144 => 44,  139 => 43,  134 => 6,  128 => 5,  122 => 45,  119 => 44,  117 => 44,  112 => 42,  107 => 39,  100 => 34,  94 => 22,  88 => 6,  82 => 25,  79 => 18,  74 => 22,  70 => 21,  65 => 19,  60 => 18,  58 => 17,  46 => 7,  35 => 7,  23 => 1,  50 => 8,  43 => 8,  40 => 8,  33 => 6,  30 => 3,  42 => 14,  39 => 6,  32 => 12,  29 => 4,);
    }
}
