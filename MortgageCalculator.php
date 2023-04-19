<!DOCTYPE html>
<html>

<head>
    <title>Mortgage Calculator</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>
    <div class="background-video-container">
        <video autoplay muted loop id="background-video">
            <source src="images/musoka.mp4" type="video/mp4">
        </video>
    </div>

    <div class="main-container">
        <div class="logo-container">
            <img src="images/logo.png" alt="Logo" id="logo">
        </div>

        <div class="form-container" id="form-container">
            <div class="form-container">
                <h1>Mortgage Calculator</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                    <label>Property Price:</label>
                    <input type="number" name="property_price" required><br>
                    <label>Down Payment:</label>
                    <input type="number" name="down_payment" required><br>
                    <label>Interest Rate (%):</label>
                    <input type="number" step="0.01" name="interest_rate" required><br>
                    <label>Loan Term (years):</label>
                    <input type="number" name="loan_term" required><br>
                    <input type="submit" value="Calculate">
                </form>
            </div>
            <div class="results-container" id="results-container" style="display: none;">
                <p id="monthly-payment"></p>
                <p id="total-payment"></p>
                <p id="total-interest-paid"></p>
                <button id="start-over">Start Over</button>
            </div>
        </div>
    </div>
    </div>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Retrieve user inputs from the form
        $property_price = $_GET['property_price'];
        $down_payment = $_GET['down_payment'];
        $interest_rate = $_GET['interest_rate'] / 100;
        $loan_term = $_GET['loan_term'];

        // Calculate the loan amount
        $loan_amount = $property_price - $down_payment;
        // Convert the interest rate to a monthly interest rate
        $monthly_interest_rate = $interest_rate / 12;
        // Calculate the number of payments based on the loan term
        $number_of_payments = $loan_term * 12;

        // Calculate the monthly mortgage payment
        $monthly_payment = $loan_amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $number_of_payments)) / (pow(1 + $monthly_interest_rate, $number_of_payments) - 1);
        // Calculate the total payment
        $total_payment = $monthly_payment * $number_of_payments;
        // Calculate the total interest paid
        $total_interest_paid = $total_payment - $loan_amount;

        // Display the calculated results
        echo "Monthly Payment: $" . number_format($monthly_payment, 2) . "<br>";
        echo "Total Payment: $" . number_format($total_payment, 2) . "<br>";
        echo "Total Interest Paid: $" . number_format($total_interest_paid, 2);
    }
    ?>
    <script>
        // Add this script to display the results and handle the "Start Over" button
        document.getElementById('start-over').addEventListener('click', () => {
            document.getElementById('results-container').style.display = 'none';
            document.getElementById('form-container').style.display = 'block';
        });

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Display the calculated results
            echo "document.getElementById('monthly-payment').innerText = 'Monthly Payment: $" . number_format($monthly_payment, 2) . "';";
            echo "document.getElementById('total-payment').innerText = 'Total Payment: $" . number_format($total_payment, 2) . "';";
            echo "document.getElementById('total-interest-paid').innerText = 'Total Interest Paid: $" . number_format($total_interest_paid, 2) . "';";
            echo "document.getElementById('results-container').style.display = 'block';";
            echo "document.getElementById('form-container').style.display = 'none';";
        }
        ?>
    </script>
</body>

</html>