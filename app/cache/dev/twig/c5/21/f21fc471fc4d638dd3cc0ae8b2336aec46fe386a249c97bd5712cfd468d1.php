<?php

/* WSOvsBundle:Evenement:list.html.twig */
class __TwigTemplate_c521f21fc471fc4d638dd3cc0ae8b2336aec46fe386a249c97bd5712cfd468d1 extends Twig_Template
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
        echo " - list evenement
";
    }

    // line 6
    public function block_ovs($context, array $blocks = array())
    {
        // line 7
        echo "    Liste evènement du ";
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["date"]) ? $context["date"] : $this->getContext($context, "date")), "date"), "d/m/Y"), "html", null, true);
        echo "
    ";
        // line 8
        if ((!twig_test_empty((isset($context["evenements"]) ? $context["evenements"] : $this->getContext($context, "evenements"))))) {
            // line 9
            echo "        <table>
            <tr>
                <th>Heure</th>
                <th>Sport</th>
                <th>Sortie</th>
                <th>Inscrit</th>
                <th>organisateur</th>
            </tr>
            ";
            // line 17
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["evenements"]) ? $context["evenements"] : $this->getContext($context, "evenements")));
            foreach ($context['_seq'] as $context["_key"] => $context["evenement"]) {
                // line 18
                echo "                <tr>
                    <td>";
                // line 19
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["evenement"]) ? $context["evenement"] : $this->getContext($context, "evenement")), "heure"), "H:i"), "html", null, true);
                echo "</td>
                    <td>";
                // line 20
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["evenement"]) ? $context["evenement"] : $this->getContext($context, "evenement")), "sport"), "nom"), "html", null, true);
                echo "</td>
                    <td>";
                // line 21
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["evenement"]) ? $context["evenement"] : $this->getContext($context, "evenement")), "nom"), "html", null, true);
                echo "</td>
                    <td>";
                // line 22
                echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["evenement"]) ? $context["evenement"] : $this->getContext($context, "evenement")), "userEvenements")), "html", null, true);
                echo " / ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["evenement"]) ? $context["evenement"] : $this->getContext($context, "evenement")), "inscrit"), "html", null, true);
                echo "</td>
                    <td>";
                // line 23
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["evenement"]) ? $context["evenement"] : $this->getContext($context, "evenement")), "user"), "username"), "html", null, true);
                echo "</td>
                </tr>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['evenement'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 26
            echo "        </table>
    ";
        } else {
            // line 28
            echo "        <p>Pas d'évènement pour cette date.</p>
    ";
        }
    }

    public function getTemplateName()
    {
        return "WSOvsBundle:Evenement:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 28,  93 => 26,  84 => 23,  78 => 22,  74 => 21,  70 => 20,  66 => 19,  63 => 18,  59 => 17,  49 => 9,  47 => 8,  42 => 7,  39 => 6,  32 => 4,  29 => 3,);
    }
}
