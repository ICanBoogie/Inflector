<?php

namespace ICanBoogie;

use InvalidArgumentException;

use function class_exists;

/**
 * A representation of the inflections used by an inflector.
 *
 * @property-read array $plurals Rules for {@see pluralize()}.
 * @property-read array $singulars Rules for {@see singularize()}.
 * @property-read array $uncountables Uncountables.
 * @property-read array $humans Rules for {@see humanize()}.
 * @property-read array $acronyms Acronyms.
 * @property-read string $acronym_regex Acronyms regex.
 */
final class Inflections
{
    /**
     * @var array<string , Inflections>
     */
    private static $inflections = [];

    /**
     * Returns inflections for the specified locale.
     *
     * Note: Inflections are shared for the same locale. If you need to alter an instance you
     * MUST clone it first, otherwise your changes will affect others.
     */
    public static function get(string $locale = Inflector::DEFAULT_LOCALE): Inflections
    {
        if (isset(self::$inflections[$locale])) {
            return self::$inflections[$locale];
        }

        $inflections = new self();
        $configurator = __NAMESPACE__ . "\\Inflections\\$locale";

        if (!class_exists($configurator)) {
            throw new InflectionsNotFound("Unable to load inflections for `$locale`, tried `$configurator`.");
        }

        $configurator::configure($inflections);

        return self::$inflections[$locale] = $inflections;
    }

    /**
     * Rules for {@see pluralize()}.
     *
     * @var array<string, string> Where _key_ is a rule and _value_ a replacement.
     */
    protected $plurals = [];

    /**
     * Rules for {@see singularize()}.
     *
     * @var array<string, string> Where _key_ is a rule and _value_ a replacement.
     */
    protected $singulars = [];

    /**
     * Uncountables.
     *
     * @var array<string, string> Where _key_ is a word and _value_ the same word.
     */
    protected $uncountables = [];

    /**
     * Rules for {@see humanize()}.
     *
     * @var array<string, string> Where _key_ is a rule and _value_ a replacement.
     */
    protected $humans = [];

    /**
     * Acronyms.
     *
     * @var array<string, string> Where _key_ is a lower case version of _value_.
     */
    protected $acronyms = [];

    /**
     * Acronyms regex.
     *
     * @var string
     */
    protected $acronym_regex = '/(?=a)b/';

    /**
     * Returns the {@see $acronyms}, {@see $acronym_regex}, {@see $plurals}, {@see $singulars},
     * {@see $uncountables} and {@see $humans} properties.
     *
     * @param string $property
     *
     * @return mixed
     *
     * @throws PropertyNotDefined in an attempt to read an inaccessible property. If the {@see PropertyNotDefined}
     * class is not available a {@see \InvalidArgumentException} is thrown instead.
     */
    public function __get(string $property)
    {
        static $readers = [ 'acronyms', 'acronym_regex', 'plurals', 'singulars', 'uncountables', 'humans' ];

        if (in_array($property, $readers)) {
            return $this->$property;
        }

        if (class_exists(PropertyNotDefined::class)) {
            throw new PropertyNotDefined([ $property, $this ]);
        } else {
            throw new InvalidArgumentException("Property not defined: $property");
        }
    }

    /**
     * Specifies a new acronym. An acronym must be specified as it will appear
     * in a camelized string. An underscore string that contains the acronym
     * will retain the acronym when passed to {@see camelize}, {@see humanize}, or
     * {@see titleize}. A camelized string that contains the acronym will maintain
     * the acronym when titleized or humanized, and will convert the acronym
     * into a non-delimited single lowercase word when passed to {@see underscore}.
     *
     * <pre>
     * $this->acronym('HTML');
     * $this->titleize('html');                 // 'HTML'
     * $this->camelize('html');                 // 'HTML'
     * $this->underscore('MyHTML');             // 'my_html'
     * </pre>
     *
     * The acronym, however, must occur as a delimited unit and not be part of
     * another word for conversions to recognize it:
     *
     * <pre>
     * $this->acronym('HTTP');
     * $this->camelize('my_http_delimited');    // 'MyHTTPDelimited'
     * $this->camelize('https');                // 'Https', not 'HTTPs'
     * $this->underscore('HTTPS');              // 'http_s', not 'https'
     *
     * $this->acronym('HTTPS');
     * $this->camelize('https');                // 'HTTPS'
     * $this->underscore('HTTPS');              // 'https'
     * </pre>
     *
     * Note: Acronyms that are passed to {@see pluralize} will no longer be
     * recognized, since the acronym will not occur as a delimited unit in the
     * pluralized result. To work around this, you must specify the pluralized
     * form as an acronym as well:
     *
     * <pre>
     * $this->acronym('API');
     * $this->camelize($this->pluralize('api')); // 'Apis'
     *
     * $this->acronym('APIs');
     * $this->camelize($this->pluralize('api')); // 'APIs'
     * </pre>
     *
     * {@see acronym} may be used to specify any word that contains an acronym or
     * otherwise needs to maintain a non-standard capitalization. The only
     * restriction is that the word must begin with a capital letter.
     *
     * <pre>
     * $this->acronym('RESTful');
     * $this->underscore('RESTful');             // 'restful'
     * $this->underscore('RESTfulController');   // 'restful_controller'
     * $this->titleize('RESTfulController');     // 'RESTful Controller'
     * $this->camelize('restful');               // 'RESTful'
     * $this->camelize('restful_controller');    // 'RESTfulController'
     *
     * $this->acronym('McHammer');
     * $this->underscore('McHammer');            // 'mchammer'
     * $this->camelize('mchammer');              // 'McHammer'
     * </pre>
     *
     * @return $this
     */
    public function acronym(string $acronym): self
    {
        $this->acronyms[StaticInflector::downcase($acronym)] = $acronym;
        $this->acronym_regex = '/' . implode('|', $this->acronyms) . '/';

        return $this;
    }

    /**
     * Specifies a new pluralization rule and its replacement.
     *
     * <pre>
     * $this->plural('/^(ax|test)is$/i', '\1es');
     * $this->plural('/(buffal|tomat)o$/i', '\1oes');
     * $this->plural('/^(m|l)ouse$/i', '\1ice');
     * </pre>
     *
     * @param string $rule A regex string.
     * @param string $replacement The replacement should always be a string that may include
     * references to the matched data from the rule.
     *
     * @return $this
     */
    public function plural(string $rule, string $replacement): self
    {
        unset($this->uncountables[$rule]);
        unset($this->uncountables[$replacement]);

        $this->plurals = [ $rule => $replacement ] + $this->plurals;

        return $this;
    }

    /**
     * Specifies a new singularization rule and its replacement.
     *
     * <pre>
     * $this->singular('/(n)ews$/i', '\1ews');
     * $this->singular('/([^aeiouy]|qu)ies$/i', '\1y');
     * $this->singular('/(quiz)zes$/i', '\1');
     * </pre>
     *
     * @param string $rule A regex string.
     * @param string $replacement The replacement should always be a string that may include
     * references to the matched data from the rule.
     *
     * @return $this
     */
    public function singular(string $rule, string $replacement): self
    {
        unset($this->uncountables[$rule]);
        unset($this->uncountables[$replacement]);

        $this->singulars = [ $rule => $replacement ] + $this->singulars;

        return $this;
    }

    /**
     * Specifies a new irregular that applies to both pluralization and singularization at the
     * same time. This can only be used for strings, not regular expressions. You simply pass
     * the irregular in singular and plural form.
     *
     * <pre>
     * $this->irregular('child', 'children');
     * $this->irregular('person', 'people');
     * </pre>
     *
     * @return $this
     */
    public function irregular(string $singular, string $plural): self
    {
        unset($this->uncountables[$singular]);
        unset($this->uncountables[$plural]);

        $s0 = mb_substr($singular, 0, 1);
        $s0_upcase = StaticInflector::upcase($s0);
        $srest = mb_substr($singular, 1);

        $p0 = mb_substr($plural, 0, 1);
        $p0_upcase = StaticInflector::upcase($p0);
        $prest = mb_substr($plural, 1);

        if ($s0_upcase == $p0_upcase) {
            $this->plural("/({$s0}){$srest}$/i", '\1' . $prest);
            $this->plural("/({$p0}){$prest}$/i", '\1' . $prest);

            $this->singular("/({$s0}){$srest}$/i", '\1' . $srest);
            $this->singular("/({$p0}){$prest}$/i", '\1' . $srest);
        } else {
            $s0_downcase = StaticInflector::downcase($s0);
            $p0_downcase = StaticInflector::downcase($p0);

            $this->plural("/{$s0_upcase}(?i){$srest}$/", $p0_upcase . $prest);
            $this->plural("/{$s0_downcase}(?i){$srest}$/", $p0_downcase . $prest);
            $this->plural("/{$p0_upcase}(?i){$prest}$/", $p0_upcase . $prest);
            $this->plural("/{$p0_downcase}(?i){$prest}$/", $p0_downcase . $prest);

            $this->singular("/{$s0_upcase}(?i){$srest}$/", $s0_upcase . $srest);
            $this->singular("/{$s0_downcase}(?i){$srest}$/", $s0_downcase . $srest);
            $this->singular("/{$p0_upcase}(?i){$prest}$/", $s0_upcase . $srest);
            $this->singular("/{$p0_downcase}(?i){$prest}$/", $s0_downcase . $srest);
        }

        return $this;
    }

    /**
     * Add uncountable words that shouldn't be attempted inflected.
     *
     * <pre>
     * $this->uncountable('money');
     * $this->uncountable(explode(' ', 'money information rice'));
     * </pre>
     *
     * @param string|string[] $word
     *
     * @return $this
     */
    public function uncountable($word): self
    {
        if (is_array($word)) {
            $this->uncountables += array_combine($word, $word);

            return $this;
        }

        $this->uncountables[$word] = $word;

        return $this;
    }

    /**
     * Specifies a humanized form of a string by a regular expression rule or by a string mapping.
     * When using a regular expression based replacement, the normal humanize formatting is
     * called after the replacement. When a string is used, the human form should be specified
     * as desired (example: 'The name', not 'the_name').
     *
     * <pre>
     * $this->human('/_cnt$/i', '\1_count');
     * $this->human('legacy_col_person_name', 'Name');
     * </pre>
     *
     * @param string $rule A regular expression rule or a string mapping. Strings that starts with
     * "/", "#" or "~" are recognized as regular expressions.
     *
     * @return $this
     */
    public function human(string $rule, string $replacement): self
    {
        $r0 = $rule[0];

        if ($r0 != '/' && $r0 != '#' && $r0 != '~') {
            $rule = '/' . preg_quote($rule, '/') . '/';
        }

        $this->humans = [ $rule => $replacement ] + $this->humans;

        return $this;
    }
}
