<?php
declare(strict_types=1);

namespace Plaisio\LanguageResolver\Test\Plaisio;

use Plaisio\Babel\Babel;
use Plaisio\Babel\CoreBabel;
use Plaisio\Kernel\Nub;
use Plaisio\LanguageResolver\CoreLanguageResolver;
use Plaisio\LanguageResolver\LanguageResolver;

/**
 * Mock framework for testing purposes.
 */
class TestKernel extends Nub
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the helper object for retrieving linguistic entities.
   *
   * @return Babel
   */
  protected function getBabel(): Babel
  {
    return new CoreBabel();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the data layer generated by PhpStratum.
   *
   * @return Object
   */
  protected function getDL(): Object
  {
    return new TestDataLayer();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return LanguageResolver
   */
  protected function getLanguageResolver(): LanguageResolver
  {
    return new CoreLanguageResolver(C::LAN_ID_EN);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
