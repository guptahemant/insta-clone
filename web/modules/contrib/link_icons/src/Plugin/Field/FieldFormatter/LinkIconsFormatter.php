<?php

namespace Drupal\link_icons\Plugin\Field\FieldFormatter;

/**
 * @file
 * Contains \Drupal\link_icons\Plugin\Field\FieldFormatter\LinkIconsFormatter.
 */

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;

/**
 * Plugin implementation of the 'link_icons_formatter' formatter.
 *
 * @FieldFormatter (
 *   id = "link_icons_formatter",
 *   label = @Translation("Link with service icon"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class LinkIconsFormatter extends FormatterBase {

  /**
   * Array of hostnames.
   */
  protected $hostnames;

  /**
   * Class.
   */
  protected $class;

  /**
   * Icon.
   */
  protected $icon;

  /**
   * Icon Style.
   */
  protected $icon_style;

  /**
   * Icon Square.
   */
  protected $icon_square;

  /**
   * Icon Circle.
   */
  protected $icon_circle;

  /**
   * Color.
   */
  protected $color;

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['text'] = [
      '#type' => 'select',
      '#title' => $this->t('Text alongside the icon'),
      '#description' => $this->t('Select what text should appear with each icon (if any)'),
      '#default_value' => $this->getSetting('text'),
      '#required' => FALSE,
      '#empty_value' => 'none',
      '#options' => [
        'title or else URL' => $this->t('Link title, or URL if no title'),
        'title' => $this->t('Link title'),
        'URL' => $this->t('Link URL'),
        'title - URL' => $this->t('Link title - link URL'),
        'title: URL' => $this->t('Link title: link URL'),
        'URL (title)' => $this->t('link URL (Link title)'),
      ],
    ];

    $form['hideURLscheme'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide the scheme from the URL?'),
      '#description' => $this->t("Should the scheme (ex. 'http://', 'https://', 'mailto:', 'tel:') be hidden from the URL, if it is used in the text?"),
      '#default_value' => $this->getSetting('hideURLscheme'),
      '#required' => FALSE,
    ];

    $form['order'] = [
      '#type' => 'select',
      '#title' => $this->t('Order of icon and text'),
      '#description' => $this->t('Select the order of each icon and its text (if any)'),
      '#default_value' => $this->getSetting('order'),
      '#required' => TRUE,
      '#options' => [
        'first' => $this->t('Icon first'),
        'last' => $this->t('Icon last'),
      ],
    ];

    $form['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Size of the icon'),
      '#description' => $this->t('Select what size each icon should be (not used/supported if icons have a background [see setting below])'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#options' => [
        '1x' => $this->t('100%'),
        'lg' => $this->t('133%'),
        '2x' => $this->t('200%'),
        '3x' => $this->t('300%'),
        '4x' => $this->t('400%'),
        '5x' => $this->t('500%'),
      ],
    ];

    $form['width'] = [
      '#type' => 'select',
      '#title' => $this->t('Width of icons'),
      '#description' => $this->t('Select whether each icon should have a fixed or variable width (helps with horizontal alignment)'),
      '#default_value' => $this->getSetting('width'),
      '#required' => TRUE,
      '#options' => [
        'fixed' => $this->t('Fixed width'),
        'variable' => $this->t('Variable width'),
      ],
    ];

    $form['coloured'] = [
      '#type' => 'select',
      '#title' => $this->t('Coloured icons'),
      '#description' => $this->t("Select whether each service icon should be coloured correctly (if that's possible with a single colour)"),
      '#default_value' => $this->getSetting('coloured'),
      '#required' => TRUE,
      '#options' => [
        'coloured' => $this->t('Coloured'),
        'uncoloured' => $this->t('Uncoloured'),
      ],
    ];

    $form['shaped'] = [
      '#type' => 'select',
      '#title' => $this->t('Pre-shaped icons'),
      '#description' => $this->t('Select whether each service icon should be the pre-squared or pre-circled version (if available)'),
      '#default_value' => $this->getSetting('shaped'),
      '#required' => TRUE,
      '#options' => [
        'squared' => $this->t('Squared'),
        'circled' => $this->t('Circled'),
        'squared or else circled' => $this->t('Squared, or else circled'),
        'circled or else squared' => $this->t('Circled, or else squared'),
        'natural' => $this->t('Natural'),
      ],
    ];

    $form['background'] = [
      '#type' => 'select',
      '#title' => $this->t('Background of the icons'),
      '#description' => $this->t('Select what background each icon should have (if any)'),
      '#default_value' => $this->getSetting('background'),
      '#required' => FALSE,
      '#empty_value' => 'none',
      '#options' => [
        'square' => $this->t('Square with rounded corners solid'),
        'square-o' => $this->t('Square with rounded corners outline'),
        'stop' => $this->t('Square solid'),
        'play' => $this->t('Triangle pointing right (play symbol) solid'),
        'circle'  => $this->t('Circle solid'),
        'circle-o' => $this->t('Circle outline'),
        'circle-o-notch' => $this->t('Circle outline with notch at the top'),
        'circle-thin' => $this->t('Circle outline hairline'),
        'dot-circle-o' => $this->t('Circle outline with centre dot'),
        'cloud' => $this->t('Cloud solid'),
        'sun-o' => $this->t('Sun outline'),
        'folder' => $this->t('Folder solid'),
        'folder-o' => $this->t('Folder outline'),
        'file' => $this->t('File solid'),
        'file-o' => $this->t('File outline'),
        'heart' => $this->t('Heart solid'),
        'heart-o' => $this->t('Heart outline'),
        'laptop' => $this->t('Laptop'),
        'tablet' => $this->t('Tablet'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('Output @text text@scheme with @size size @width width @coloured @shaped icons, @background backgrounds and the icons placed @order.',
      [
        '@text' => ($this->getSetting('text') == 'none' ? 'no' : '"' . $this->getSetting('text') . '"'),
        '@scheme' => ($this->getSetting('hideURLscheme') ? ' (with scheme hidden from URLs)' : ''),
        '@order' => $this->getSetting('order'),
        '@size' => $this->getSetting('size'),
        '@width' => $this->getSetting('width'),
        '@coloured' => $this->getSetting('coloured'),
        '@shaped' => $this->getSetting('shaped'),
        '@background' => ($this->getSetting('background') == 'none' ? 'no' : 'fa-' . $this->getSetting('background')),
      ]
    );

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'text' => 'title',
      'hideURLscheme' => TRUE,
      'order' => 'first',
      'size' => '1x',
      'width' => 'fixed',
      'coloured' => 'coloured',
      'shaped' => 'natural',
      'background' => 'none',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $services = \Drupal::entityTypeManager()->getStorage('link_icon_service')->loadMultiple();

    $elements = [];

    // Step through the items.
    foreach ($items as $delta => $item) {
      $parsed = parse_url($item->getUrl()->toString());

      if (isset($parsed['scheme'])) {
        switch ($parsed['scheme']) {
          case 'mailto':
            $service = [
              'id' => 'mailto',
              'class' => 'mailto',
              'icon' => 'envelope',
              'icon_style' => 'solid',
              'icon_square' => 'envelope-square',
              'color' => 'navy',
            ];

            break;

          case 'tel':
            $service = [
              'id' => 'tel',
              'class' => 'tel',
              'icon' => 'phone',
              'icon_style' => 'solid',
              'icon_square' => 'phone-square',
              'color' => 'navy',
            ];

            break;

          case 'http':
          case 'https':
          default:
            $chunks = explode('.', $parsed['host']);
            $host3 = '';
            if (count($chunks) == 1) {
              $host = $chunks[0];
            }
            else {
              $host = $chunks[count($chunks) - 2] . '.' . $chunks[count($chunks) - 1];
              if (count($chunks) > 2) {
                $host3 = $chunks[count($chunks) - 3] . '.' . $host;
              }
            }

            // Set the default service to a generic navy globe.
            $service = [
              'class' => 'generic',
              'icon' => 'globe',
              'icon_style' => 'solid',
              'color' => 'navy',
            ];

            // Find the service from $services.
            foreach ($services as $aservice) {
              foreach ($aservice->get('hostnames') as $hostname) {
                if (($hostname == $host3) || $hostname == $host) {
                  $service = [
                    'id' => $aservice->get('id'),
                    'class' => $aservice->get('class') ?: $aservice->get('id'),
                    'icon' => $aservice->get('icon'),
                    'icon_style' => $aservice->get('icon_style'),
                    'icon_square' => $aservice->get('icon_square') ?: '',
                    'icon_circle' => $aservice->get('icon_circle') ?: '',
                    'color' => $aservice->get('color') ?: '',
                  ];
                }
              }
            }

            break;

        }
      }

      $hollow_endings = [
        '-o',
        '-o-notch',
        '-thin',
        'sun',
        'laptop',
        'tablet',
      ];

      // Determine if the icon needs to be inverted.
      if ($this->getSetting('background') != 'none') {
        $inverse = TRUE;
        foreach ($hollow_endings as $ending) {
          if ($inverse) {
            $ending_length = strlen($ending);
            if ($ending_length <= strlen($this->getSetting('background'))) {
              if (substr_compare($this->getSetting('background'), $ending, -$ending_length) === 0) {
                $inverse = FALSE;
              }
            }
          }
        }
      }

      switch ($this->getSetting('shaped')) {
        case 'squared':
          $icon = $service['icon_square'] ?: $service['icon'];
          break;

        case 'squared or else circled':
          $icon = $service['icon_square'] ?: ($service['icon_circle'] ?: $service['icon']);
          break;

        case 'circled':
          $icon = $service['icon_circle'] ?: $service['icon'];
          break;

        case 'circled or else squared':
          $icon = $service['icon_circle'] ?: ($service['icon_square'] ?: $service['icon']);
          break;

        case 'natural':
        default:
          $icon = $service['icon'];
          break;
      }

      switch ($service['icon_style']) {
        case 'solid':
          $style = 's';
          break;

        case 'regular':
          $style = 'r';
          break;

        case 'light':
          $style = 'l';
          break;

        case 'duotone':
          $style = 'd';
          break;

        case 'brand':
        default:
          $style = 'b';
          break;
      }

      // Generate the icon link HTML.
      $icon_link = Link::fromTextAndUrl(
        Markup::create(
          ($this->getSetting('background') != 'none' ? '<span class="fa-stack'
              . ($this->getSetting('size') != '1x' ? ' fa-' . $this->getSetting('size') : '')
              . '"><i class="fa fa-'
              . $this->getSetting('background')
              . ' fa-stack-2x"></i>'
            : ''
          )
          . '<i class="service ' . $service['class']
          . ' fa' . $style
          . ' fa-' . $icon
          . ($this->getSetting('background') == 'none' && $this->getSetting('size') != '1x' ? ' fa-' . $this->getSetting('size') : '')
          . ($this->getSetting('width') == 'fixed' ? ' fa-fw' : '')
          . ($this->getSetting('background') != 'none' ? ' fa-stack-1x' . (isset($inverse) && $inverse ? ' fa-inverse' : '') : '')
          . '"'
          . ($this->getSetting('coloured') != 'uncoloured' ? ' style="color: ' . $service['color'] . ';"' : '')
          . '></i>'
          . ($this->getSetting('background') != 'none' ? '</span>' : '')
        ),
        Url::fromUri(
          $item->getUrl()->toString(),
          [
            'attributes' => [
              'title' => $item->title,
              'target' => '_blank',
            ],
          ]
        )
      )->toString();

      // Generate the text HTML, if required, and combine it with the link icon
      // HTML in $markup.
      $text = '';

      $url = $item->getUrl()->toString();
      if ($this->getSetting('hideURLscheme') == TRUE) {
        $parsed = parse_url($url);

        if ($parsed['scheme'] != '') {
          $url = substr($url, strlen($parsed['scheme']));
          $url = substr($url, 0, 3) == '://' ? substr($url, 3) : $url;
          $url = substr($url, 0, 1) == ':' ? substr($url, 1) : $url;
        }
      }

      if ($this->getSetting('text') != 'none') {
        switch ($this->getSetting('text')) {
          case 'title or else URL':
            $text = $item->title;
            if ($text == '') {
              $text = $url;
            }
            break;

          case 'title':
            $text = $item->title;
            break;

          case 'URL':
            $text = $url;
            break;

          case 'title - URL':
            $text = $item->title . ' - ' . $url;
            break;

          case 'title: URL':
            $text = $item->title . ': ' . $url;
            break;

          case 'URL (title)':
            $text = $url . ' (' . $item->title . ')';
            break;
        }

        $text_link = Link::fromTextAndUrl(
          $text,
          Url::fromUri(
            $item->getUrl()->toString(),
            [
              'attributes' => [
                'title' => $item->title,
                'target' => '_blank',
              ],
            ]
          )
        )->toString();

        if ($this->getSetting('order') == 'first') {
          $markup = $icon_link . ' ' . $text_link;
        }
        else {
          $markup = $text_link . ' ' . $icon_link;
        }
      }
      else {
        $markup = $icon_link;
      }

      // Return the $markup.
      $elements[$delta] = [
        '#markup' => Markup::create($markup),
      ];
    }

    return $elements;
  }

}
