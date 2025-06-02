# Iranian Bank List for Laravel

A comprehensive Laravel package for Iranian banking operations including bank identification, IBAN validation, and card number verification.

## Features

- Complete list of Iranian banks with details
- IBAN validation using mod-97 algorithm
- Iranian card number validation using Luhn algorithm
- Bank identification by IBAN, card number, or name
- FilamentPHP integration support
- Easy-to-use facade and model interfaces

## Installation

1. **Install the package via Composer:**

   ```bash
   composer require emadshirzad/iranian-bank-list-laravel
   ```

2. **Publish the configuration file:**

   ```bash
   php artisan vendor:publish --tag=iranian-bank-config
   ```

3. **Run the migration to create the banks table:**

   ```bash
   php artisan migrate
   ```

4. **Seed the database with bank data:**
   ```bash
   php artisan db:seed --class=IranianBankSeeder
   ```

## Usage

### Getting All Banks

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

// Using facade
$banks = IranianBank::getBanks();

// Or using model directly
use App\Models\IranianBank;
$banks = IranianBank::all();
```

### Bank Identification

**Get bank details by IBAN:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$bank = IranianBank::getBankByIban('IR123456789012345678901234567890');
// Returns bank details or null if not found
```

**Get bank details by card number:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$bank = IranianBank::getBankByCardNumber('6037991234567890');
// Returns bank details or null if not found
```

**Find bank by name:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$bank = IranianBank::findByName('melli');
// Returns bank details or null if not found
```

### Advanced Search Methods

**Find bank by full card number using regex:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$bank = IranianBank::findByCardNumber('6037991234567890');
// Returns bank details or null if not found
```

**Find bank by full IBAN using regex:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$bank = IranianBank::findByIban('IR123456789012345678901234567890');
// Returns bank details or null if not found
```

### Validation Methods

**Validate IBAN:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$isValid = IranianBank::validateIban('IR123456789012345678901234567890');
// Returns true or false
```

**Validate Iranian card number using Luhn algorithm:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$isValid = IranianBank::validateIranianCard('6037991234567890');
// Returns true or false
```

**Validate IBAN checksum using mod-97 algorithm:**

```php
use EmadShirzad\IranianBank\Facades\IranianBank;

$isValid = IranianBank::validateChecksum('IR123456789012345678901234567890');
// Returns true or false
```

## FilamentPHP Integration

If you're using FilamentPHP, you can easily create an admin interface for the bank data:

1. **Create a Filament resource:**

   ```bash
   php artisan make:filament-resource IranianBank
   ```

2. **Update the resource file** at `app/Filament/Resources/IranianBankResource.php` using the package methods.

3. **Example implementation** can be found in the [FilamentResource example file](https://github.com/Emadshirzad/iranian-bank-list-laravel/tree/master/assets/IranianBankResource.php).

The FilamentPHP integration provides a clean admin interface for managing Iranian bank data:

![Filament Interface](https://github.com/Emadshirzad/iranian-bank-list-laravel/blob/master/assets/image.png)

## Documentation

For detailed FilamentPHP usage, refer to the [official FilamentPHP documentation](https://filamentphp.com/docs/3.x/panels/installation).

## Requirements

- PHP >= 8.0
- Laravel >= 9.0

## License

This package is open-sourced software licensed under the [MIT License](https://opensource.org/license/mit/).

## Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Support

If you encounter any issues or have questions, please [open an issue](https://github.com/EmadShirzad/iranian-bank-list-laravel/issues) on GitHub.

## Author

**[Emad Shirzad](https://github.com/EmadShirzad)**

---

Made with ❤️ for the Laravel community
