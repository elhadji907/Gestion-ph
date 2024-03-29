<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <script>
        // This script is explained line by line in depth in the following video:
        // http://www.developphp.com/view.php?tid=1389
        function computeLoan() {
            var amount = document.getElementById('amount').value;
            var interest_rate = document.getElementById('interest_rate').value;
            var months = document.getElementById('months').value;
            var interest = (amount * (interest_rate * .01)) / months;
            var payment = ((amount / months) + interest).toFixed(2);
            payment = payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById('payment').innerHTML = "Monthly Payment = $" + payment;
        }
    </script>
</head>

<body>
    <p>Loan Amount: $<input id="amount" type="number" min="1" max="1000000" onchange="computeLoan()"></p>
    <p>Interest Rate: <input id="interest_rate" type="number" min="0" max="100" value="10" step=".1"
            onchange="computeLoan()">%</p>
    <p>Months: <input id="months" type="number" min="1" max="72" value="1" step="1"
            onchange="computeLoan()"></p>
    <h2 id="payment"></h2>
</body>

</html>
