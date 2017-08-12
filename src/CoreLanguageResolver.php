<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\LanguageResolver;

use SetBased\Abc\Abc;

/**
 * Class for resolving the language in which a response must be drafted based on $_SERVER['HTTP_ACCEPT_LANGUAGE'].
 */
class CoreLanguageResolver implements LanguageResolver
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The ID of the language when to requested language can not be resolved.
   *
   * @var int
   */
  private $lanIdDefault;

  /**
   * The ID of the language.
   *
   * @var int|null
   */
  private $lanId;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param int $lanIdDefault The ID of the language when to requested language can not be resolved.
   */
  public function __construct($lanIdDefault)
  {
    $this->lanIdDefault = $lanIdDefault;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the language in which the response must be drafted.
   *
   * @return int
   */
  public function getLanId()
  {
    if ($this->lanId===null) $this->resolveLanId();

    return $this->lanId;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Resolves the ID of the language in which the response must be drafted.
   */
  private function resolveLanId()
  {
    $codes = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null);

    // If HTTP_ACCEPT_LANGUAGE is not set or empty return the default language.
    if (empty($codes)) $this->lanIdDefault;

    $languages = Abc::$DL->abcBabelLanguageGetAllCodes();

    // Try to find the language code. Examples: en, en-US, zh, zh-Hans.
    foreach($codes as $code)
    {
      // Remove sorting weight. BTW We assume HTTP_ACCEPT_LANGUAGE is sorted properly.
      $code = strtok($code, ';');

      if (isset($languages[$code]))
      {
        $this->lanId = $languages[$code]['lan_id'];

        return;
      }
    }

    // We did not find the language code. Try without county code. Examples: en, zh.
    foreach($codes as $code)
    {
      $code = strtok($code, ';');

      if (strpos($code, '-')===false) continue;

      $code = substr($code, 0, 2);

      if (isset($languages[$code]))
      {
        $this->lanId = $languages[$code]['lan_id'];

        return;
      }
    }

    // We did not find the language code. Use the ID of the default language.
    $this->lanId = $this->lanIdDefault;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------