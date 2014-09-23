<?php

/* base.html.twig */
class __TwigTemplate_1c143fa14d05d180e90958f88406e35e7d8eda4985ab366e1b9850dbc442af6e extends Twig_Template
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
            <div id=\"chat_div\">
            </div>
            <hr />
            <a href=\"";
        // line 39
        echo $this->env->getExtension('routing')->getPath("ws_chat_voir");
        echo "\">voir</a>
            <div>
                ";
        // line 41
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("WSChatBundle:Chat:listUser"));
        echo "
            </div>
            ";
        // line 43
        $this->displayBlock('body', $context, $blocks);
        // line 44
        echo "            ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 45
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

    // line 43
    public function block_body($context, array $blocks = array())
    {
    }

    // line 44
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  144 => 44,  139 => 43,  134 => 6,  128 => 5,  122 => 45,  119 => 44,  117 => 43,  112 => 41,  107 => 39,  100 => 34,  94 => 31,  88 => 28,  82 => 25,  79 => 24,  74 => 22,  70 => 21,  65 => 19,  60 => 18,  58 => 17,  46 => 11,  35 => 7,  23 => 1,  50 => 12,  43 => 6,  40 => 5,  33 => 6,  30 => 2,  42 => 10,  39 => 5,  32 => 3,  29 => 5,);
    }
}
