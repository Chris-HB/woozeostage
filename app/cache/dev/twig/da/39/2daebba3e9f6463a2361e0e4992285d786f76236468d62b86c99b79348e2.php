<?php

/* ::base.html.twig */
class __TwigTemplate_da392daebba3e9f6463a2361e0e4992285d786f76236468d62b86c99b79348e2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        <script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js\"></script>
        <link type=\"text/css\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/jquery.ui.chatbox.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
        <script src=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/jquery.ui.chatbox.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/chat.js"), "html", null, true);
        echo "\"></script>
    </head>
    <body>
        <header>
            <div id=\"user_header\">
            ";
        // line 17
        if ($this->env->getExtension('security')->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            // line 18
            echo "                <div id=\"pseudo\" data-pseudo=";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user"), "username"), "html", null, true);
            echo ">
                    Bonjour ";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user"), "username"), "html", null, true);
            echo "
                </div> 
                - <a href=\"";
            // line 21
            echo $this->env->getExtension('routing')->getPath("fos_user_security_logout");
            echo "\">Déconnexion</a>
                <a href=\"";
            // line 22
            echo $this->env->getExtension('routing')->getPath("fos_user_profile_show");
            echo "\">Votre Profil</a>
             ";
        } else {
            // line 24
            echo "                    <div id=\"connexion\">
                        <a href=\"";
            // line 25
            echo $this->env->getExtension('routing')->getPath("fos_user_security_login");
            echo "\">Connexion</a>&nbsp
                    </div>
                    <div id=\"register\">
                        <a href=\"";
            // line 28
            echo $this->env->getExtension('routing')->getPath("fos_user_registration_register");
            echo "\">S'enregistrer</a>&nbsp
                    </div>
                    <div id=\"forget_password\">
                        <a href=\"";
            // line 31
            echo $this->env->getExtension('routing')->getPath("fos_user_resetting_request");
            echo "\">Mot de passe oublié</a>&nbsp
                    </div>
                ";
        }
        // line 34
        echo "            </div>
        </header>
            <div id=\"menu\">
                <ul>
                    <li><a href=\"";
        // line 38
        echo $this->env->getExtension('routing')->getPath("ws_ovs_date_add");
        echo "\">ajouter date</a></li>
                    <li><a href=\"";
        // line 39
        echo $this->env->getExtension('routing')->getPath("ws_ovs_date_list");
        echo "\">liste date</a></li>
                    <li><a href=\"";
        // line 40
        echo $this->env->getExtension('routing')->getPath("ws_ovs_sport_add");
        echo "\">ajouter sport</a></li>
                    <li><a href=\"";
        // line 41
        echo $this->env->getExtension('routing')->getPath("ws_ovs_sport_list");
        echo "\">liste sport</a></li>
                </ul>
            </div>
            <div id=\"chat_div\">
            </div>
            <hr />
            <a href=\"";
        // line 47
        echo $this->env->getExtension('routing')->getPath("ws_chat_voir");
        echo "\">voir</a>
            <div>
                ";
        // line 49
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("WSChatBundle:Chat:listUser"));
        echo "
            </div>
            ";
        // line 51
        $this->displayBlock('body', $context, $blocks);
        // line 52
        echo "            ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 53
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "WoozeoStage";
    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 51
    public function block_body($context, array $blocks = array())
    {
    }

    // line 52
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  164 => 52,  159 => 51,  154 => 6,  148 => 5,  142 => 53,  139 => 52,  137 => 51,  132 => 49,  127 => 47,  118 => 41,  114 => 40,  110 => 39,  106 => 38,  100 => 34,  94 => 31,  88 => 28,  82 => 25,  79 => 24,  74 => 22,  70 => 21,  65 => 19,  60 => 18,  58 => 17,  50 => 12,  46 => 11,  42 => 10,  35 => 7,  33 => 6,  29 => 5,  23 => 1,);
    }
}
