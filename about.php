<?php

declare(strict_types=1);

require 'Currency.php';

$currency = new Currency();

$amount = isset($_POST['amount']) ? (float)$_POST['amount'] : null;
$fromCurrency = isset($_POST['from_currency']) ? $_POST['from_currency'] : null;
$toCurrency = isset($_POST['to_currency']) ? $_POST['to_currency'] : null;
$convertedAmount = null;

if ($amount !== null && $fromCurrency !== null && $toCurrency !== null) {
    try {
        $convertedAmount = $currency->exchange($amount, $fromCurrency, $toCurrency);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Currency Converter</title>
</head>
<body>
    <div class="container mt-5">
        <form action="about.php" method="post">
            <fieldset>
                <legend>Currency Converter</legend>
                <div class="mb-3">
                    <label for="from_currency" class="form-label">From</label>
                    <select id="from_currency" name="from_currency" class="form-select">
                        <?php
                        foreach ($currency->customCurrencies() as $currencyName => $rate) {
                            $selected = $fromCurrency === $currencyName ? 'selected' : '';
                            echo "<option value=\"$currencyName\" $selected>$currencyName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="to_currency" class="form-label">To</label>
                    <select id="to_currency" name="to_currency" class="form-select">
                        <?php
                        foreach ($currency->customCurrencies() as $currencyName => $rate) {
                            $selected = $toCurrency === $currencyName ? 'selected' : '';
                            echo "<option value=\"$currencyName\" $selected>$currencyName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" id="amount" name="amount" class="form-control" value="<?php echo htmlspecialchars((string)$amount); ?>">
                </div>
                <?php if ($convertedAmount !== null): ?>
                    <div class="mb-3">
                        <label for="convertedAmount" class="form-label">Converted Amount</label>
                        <input type="text" id="convertedAmount" class="form-control" value="<?php echo htmlspecialchars((string)$convertedAmount); ?>" readonly>
                    </div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Convert</button>
            </fieldset>
        </form>
    </div>
</body>
</html>
