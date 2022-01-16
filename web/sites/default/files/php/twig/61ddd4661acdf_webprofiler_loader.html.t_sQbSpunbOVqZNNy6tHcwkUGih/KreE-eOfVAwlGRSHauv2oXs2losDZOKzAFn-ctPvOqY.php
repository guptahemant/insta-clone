<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/devel/webprofiler/templates/Profiler/webprofiler_loader.html.twig */
class __TwigTemplate_216f12ab90deaa45d0bed653cf5fbb930bcae57633d0148c19f73a96c504c8f7 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453 = $this->extensions["Drupal\\webprofiler\\Twig\\Extension\\ProfilerExtension"];
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "modules/devel/webprofiler/templates/Profiler/webprofiler_loader.html.twig"));

        // line 1
        echo "<div id=\"webprofiler";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 1, $this->source), "html", null, true);
        echo "\" class=\"sf-toolbar\" style=\"display: none\"></div>

<script>
    Webprofiler = (function () {
        \"use strict\";

        var key = 'webprofiler/profiler/',

                getPreference = function (name) {
                    if (!window.localStorage) {
                        return null;
                    }

                    return localStorage.getItem(key + name);
                },

                setPreference = function (name, value) {
                    if (!window.localStorage) {
                        return null;
                    }

                    localStorage.setItem(key + name, value);
                    return true;
                },

                load = function () {
                    ajax('";
        // line 27
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["profiler_url"] ?? null), 27, $this->source), "html", null, true);
        echo "', function (result) {
                        var toolbar = document.getElementById('webprofiler";
        // line 28
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 28, $this->source), "html", null, true);
        echo "');
                        toolbar.innerHTML = result;
                        toolbar.style.display = 'block';

                        if (getPreference('toolbar/displayState') == 'none') {
                            document.getElementById('sfToolbarMainContent-";
        // line 33
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 33, $this->source), "html", null, true);
        echo "').style.display = 'none';
                            document.getElementById('sfToolbarClearer-";
        // line 34
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 34, $this->source), "html", null, true);
        echo "').style.display = 'none';
                            document.getElementById('sfMiniToolbar-";
        // line 35
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 35, $this->source), "html", null, true);
        echo "').style.display = 'block';
                        } else {
                            document.getElementById('sfToolbarMainContent-";
        // line 37
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 37, $this->source), "html", null, true);
        echo "').style.display = 'block';
                            document.getElementById('sfToolbarClearer-";
        // line 38
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 38, $this->source), "html", null, true);
        echo "').style.display = 'block';
                            document.getElementById('sfMiniToolbar-";
        // line 39
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["token"] ?? null), 39, $this->source), "html", null, true);
        echo "').style.display = 'none';
                        }

                        var arr = toolbar.getElementsByTagName('script');
                        for (var n = 0; n < arr.length; n++) {
                            eval(arr[n].innerHTML);
                        }
                    });
                },

                ajax = function (url, callback, data) {
                    try {
                        var x = new (XMLHttpRequest || ActiveXObject)('MSXML2.XMLHTTP.3.0');
                        x.open(data ? 'POST' : 'GET', url, 1);
                        x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        x.setRequestHeader('Content-type', 'application/json');
                        x.onreadystatechange = function () {
                            x.readyState > 3 && x.status === 200 && callback && callback(x.responseText, x);
                        };
                        x.send(data);
                    } catch (e) {
                        window.console && console.log(e);
                    }
                };

        return {
            getPreference: getPreference,
            setPreference: setPreference,
            load: load,
            ajax: ajax
        }
    })();

    Webprofiler.load();
</script>
";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "modules/devel/webprofiler/templates/Profiler/webprofiler_loader.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 39,  101 => 38,  97 => 37,  92 => 35,  88 => 34,  84 => 33,  76 => 28,  72 => 27,  42 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div id=\"webprofiler{{ token }}\" class=\"sf-toolbar\" style=\"display: none\"></div>

<script>
    Webprofiler = (function () {
        \"use strict\";

        var key = 'webprofiler/profiler/',

                getPreference = function (name) {
                    if (!window.localStorage) {
                        return null;
                    }

                    return localStorage.getItem(key + name);
                },

                setPreference = function (name, value) {
                    if (!window.localStorage) {
                        return null;
                    }

                    localStorage.setItem(key + name, value);
                    return true;
                },

                load = function () {
                    ajax('{{ profiler_url }}', function (result) {
                        var toolbar = document.getElementById('webprofiler{{ token }}');
                        toolbar.innerHTML = result;
                        toolbar.style.display = 'block';

                        if (getPreference('toolbar/displayState') == 'none') {
                            document.getElementById('sfToolbarMainContent-{{ token }}').style.display = 'none';
                            document.getElementById('sfToolbarClearer-{{ token }}').style.display = 'none';
                            document.getElementById('sfMiniToolbar-{{ token }}').style.display = 'block';
                        } else {
                            document.getElementById('sfToolbarMainContent-{{ token }}').style.display = 'block';
                            document.getElementById('sfToolbarClearer-{{ token }}').style.display = 'block';
                            document.getElementById('sfMiniToolbar-{{ token }}').style.display = 'none';
                        }

                        var arr = toolbar.getElementsByTagName('script');
                        for (var n = 0; n < arr.length; n++) {
                            eval(arr[n].innerHTML);
                        }
                    });
                },

                ajax = function (url, callback, data) {
                    try {
                        var x = new (XMLHttpRequest || ActiveXObject)('MSXML2.XMLHTTP.3.0');
                        x.open(data ? 'POST' : 'GET', url, 1);
                        x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        x.setRequestHeader('Content-type', 'application/json');
                        x.onreadystatechange = function () {
                            x.readyState > 3 && x.status === 200 && callback && callback(x.responseText, x);
                        };
                        x.send(data);
                    } catch (e) {
                        window.console && console.log(e);
                    }
                };

        return {
            getPreference: getPreference,
            setPreference: setPreference,
            load: load,
            ajax: ajax
        }
    })();

    Webprofiler.load();
</script>
", "modules/devel/webprofiler/templates/Profiler/webprofiler_loader.html.twig", "/var/www/html/drupal9composer/web/modules/devel/webprofiler/templates/Profiler/webprofiler_loader.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 1);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
