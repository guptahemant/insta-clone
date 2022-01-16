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

/* themes/custom/retroo/templates/node--page.html.twig */
class __TwigTemplate_310888988a3abbe8e3286b3978b4e3090fdc80d4fba0fba1b714294677a8b5ad extends \Twig\Template
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
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "themes/custom/retroo/templates/node--page.html.twig"));

        // line 2
        $context["classes"] = [0 => "node", 1 => ("node--type-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source,         // line 4
($context["node"] ?? null), "bundle", [], "any", false, false, true, 4), 4, $this->source))), 2 => ((twig_get_attribute($this->env, $this->source,         // line 5
($context["node"] ?? null), "isPromoted", [], "method", false, false, true, 5)) ? ("node--promoted") : ("")), 3 => ((twig_get_attribute($this->env, $this->source,         // line 6
($context["node"] ?? null), "isSticky", [], "method", false, false, true, 6)) ? ("node--sticky") : ("")), 4 => (( !twig_get_attribute($this->env, $this->source,         // line 7
($context["node"] ?? null), "isPublished", [], "method", false, false, true, 7)) ? ("node--unpublished") : ("")), 5 => ((        // line 8
($context["view_mode"] ?? null)) ? (("node--view-mode-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["view_mode"] ?? null), 8, $this->source)))) : ("")), 6 => "clearfix"];
        // line 12
        echo "
";
        // line 13
        if ((twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "id", [], "any", false, false, true, 13) == 1)) {
            // line 14
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("retroo/retroo"), "html", null, true);
            echo "
";
        }
        // line 15
        echo " 

";
        // line 17
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("bartik/classy.node"), "html", null, true);
        echo "
<article";
        // line 18
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 18), 18, $this->source), "html", null, true);
        echo ">
  <header>
    ";
        // line 20
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null), 20, $this->source), "html", null, true);
        echo "
      ";
        // line 21
        if ((($context["label"] ?? null) &&  !($context["page"] ?? null))) {
            // line 22
            echo "        <h2";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["title_attributes"] ?? null), "addClass", [0 => "node__title"], "method", false, false, true, 22), 22, $this->source), "html", null, true);
            echo ">
          <a href=\"";
            // line 23
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["url"] ?? null), 23, $this->source), "html", null, true);
            echo "\" rel=\"bookmark\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["label"] ?? null), 23, $this->source), "html", null, true);
            echo "</a>
        </h2>
    ";
        }
        // line 26
        echo "    ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null), 26, $this->source), "html", null, true);
        echo "
    ";
        // line 27
        if (($context["display_submitted"] ?? null)) {
            // line 28
            echo "      <div class=\"node__meta\">
        ";
            // line 29
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["author_picture"] ?? null), 29, $this->source), "html", null, true);
            echo "
        <span";
            // line 30
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["author_attributes"] ?? null), 30, $this->source), "html", null, true);
            echo ">
          ";
            // line 31
            echo t("Submitted by @author_name on @date", array("@author_name" => ($context["author_name"] ?? null), "@date" => ($context["date"] ?? null), ));
            // line 32
            echo "        </span>
        ";
            // line 33
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["metadata"] ?? null), 33, $this->source), "html", null, true);
            echo "
      </div>
    ";
        }
        // line 36
        echo "  </header>
  <div";
        // line 37
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => "node__content", 1 => "clearfix"], "method", false, false, true, 37), 37, $this->source), "html", null, true);
        echo ">
    ";
        // line 38
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null), 38, $this->source), "html", null, true);
        echo "
  </div>
  
  ";
        // line 41
        if ((($context["view_mode"] ?? null) == "full")) {
            // line 42
            echo "    <div class=\"colorchange\">
      <h1>
        ";
            // line 44
            echo t("please report any problem with this page to info@drupalize.me.", array());
            // line 45
            echo "      </h1>
    </div>
    ";
        }
        // line 48
        echo "

    <div";
        // line 50
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => "colorchange"], "method", false, false, true, 50), 50, $this->source), "html", null, true);
        echo ">
      <h1>
        ";
        // line 52
        echo t("report info@drupalize.me.", array());
        // line 53
        echo "      </h1>
    </div>

  ";
        // line 56
        if ((($context["view_mode"] ?? null) == "full")) {
            // line 57
            echo "    <h6>
      ";
            // line 58
            echo t("please report any problem with this page to info@drupalize.me.", array());
            // line 59
            echo "    </h6>
    ";
        }
        // line 61
        echo "
</article>
";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "themes/custom/retroo/templates/node--page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  173 => 61,  169 => 59,  167 => 58,  164 => 57,  162 => 56,  157 => 53,  155 => 52,  150 => 50,  146 => 48,  141 => 45,  139 => 44,  135 => 42,  133 => 41,  127 => 38,  123 => 37,  120 => 36,  114 => 33,  111 => 32,  109 => 31,  105 => 30,  101 => 29,  98 => 28,  96 => 27,  91 => 26,  83 => 23,  78 => 22,  76 => 21,  72 => 20,  67 => 18,  63 => 17,  59 => 15,  54 => 14,  52 => 13,  49 => 12,  47 => 8,  46 => 7,  45 => 6,  44 => 5,  43 => 4,  42 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("{%
  set classes = [
    'node',
    'node--type-' ~ node.bundle|clean_class,
    node.isPromoted() ? 'node--promoted',
    node.isSticky() ? 'node--sticky',
    not node.isPublished() ? 'node--unpublished',
    view_mode ? 'node--view-mode-' ~ view_mode|clean_class,
    'clearfix',
  ]
%}

{% if(node.id == 1) %}
{{ attach_library('retroo/retroo') }}
{% endif %} 

{{ attach_library('bartik/classy.node') }}
<article{{ attributes.addClass(classes) }}>
  <header>
    {{ title_prefix }}
      {% if label and not page %}
        <h2{{ title_attributes.addClass('node__title') }}>
          <a href=\"{{ url }}\" rel=\"bookmark\">{{ label }}</a>
        </h2>
    {% endif %}
    {{ title_suffix }}
    {% if display_submitted %}
      <div class=\"node__meta\">
        {{ author_picture }}
        <span{{ author_attributes }}>
          {% trans %}Submitted by {{ author_name }} on {{ date }}{% endtrans %}
        </span>
        {{ metadata }}
      </div>
    {% endif %}
  </header>
  <div{{ content_attributes.addClass('node__content', 'clearfix') }}>
    {{ content }}
  </div>
  
  {% if view_mode == 'full' %}
    <div class=\"colorchange\">
      <h1>
        {% trans %}please report any problem with this page to info@drupalize.me.{% endtrans %}
      </h1>
    </div>
    {% endif %}


    <div{{ content_attributes.addClass('colorchange') }}>
      <h1>
        {% trans %}report info@drupalize.me.{% endtrans %}
      </h1>
    </div>

  {% if view_mode == 'full' %}
    <h6>
      {% trans %}please report any problem with this page to info@drupalize.me.{% endtrans %}
    </h6>
    {% endif %}

</article>
", "themes/custom/retroo/templates/node--page.html.twig", "/var/www/html/drupal9composer/web/themes/custom/retroo/templates/node--page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 2, "if" => 13, "trans" => 31);
        static $filters = array("clean_class" => 4, "escape" => 14);
        static $functions = array("attach_library" => 14);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'trans'],
                ['clean_class', 'escape'],
                ['attach_library']
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
