<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quotation form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    </head>
    <body class="antialiased">
        <div class="container">
            <h1 class="my-4">Enter your information below to get a quotation for your trip :</h1>
            <form method="POST" action="{{ route('quotation-form') }}">
                @csrf

                <div class="row mb-3">
                    <label for="currency" class="col-sm-1 col-form-label">Currency :</label>
                    <div class="col-sm-3">
                        <select class="form-select" id="currency" name="currency" required>
                            <option disabled selected>Choose a currency for your quotation</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>

                    <label for="start_date" class="col-sm-1 col-form-label">Start date :</label>
                    <div class="col-sm-3">
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>

                    <label for="end_date" class="col-sm-1 col-form-label">End date :</label>
                    <div class="col-sm-3">
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Generate a quotation</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    </body>
</html>
