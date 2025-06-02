<?php

namespace EmadShirzad\IranianBank\Facades;

use Illuminate\Support\Facades\Facade;

/** class IranBank
 * Facade for accessing the IranianBank service.
 * This facade provides a static interface to the underlying service,
 * allowing you to call methods on the IranianBank service.
 *  @method static array getBanks()
 *  @method static string getBankByIban(string $iban)
 * @method static string getBankByCardNumber(string $cardNumber)
 * @method static bool validateIban(string $iban)
 * @method static bool validateIranianCard(string $cardNumber)
 * @method static bool validateChecksum(string $iban)
 * @method static array findByName(string $name)
 * @method static array findByIban(string $iban)
 * @method static array findByCardNumber(string $cardNumber)
 *  @see \EmadShirzad\IranianBank\Services\IranianBankService
 * @package EmadShirzad\IranianBank\Facades
 *
 */
class IranBank extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iranBank';
    }
}
