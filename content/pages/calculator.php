<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="../../assets/css/calculator_style.css">
</head>
<body>


<div class="content">
    <div class="articles">
        <div class="calculator">
            <h3 class="header_calc">Калькулятор</h3>
            <form id="calc-form" method="post" action="">
                <input type="text" class="display" name="output" id="output" readonly required>

                <div class="buttons-grid">
                    <button type="button" onclick="appendToDisplay('/')">/</button>
                    <button type="button" onclick="appendToDisplay('*')">×</button>
                    <button type="button" onclick="appendToDisplay('-')">-</button>

                    <button type="button" onclick="appendToDisplay('7')">7</button>
                    <button type="button" onclick="appendToDisplay('8')">8</button>
                    <button type="button" onclick="appendToDisplay('9')">9</button>
                    <button type="button" onclick="appendToDisplay('+')" style="grid-row: span 2;">+</button>

                    <button type="button" onclick="appendToDisplay('4')">4</button>
                    <button type="button" onclick="appendToDisplay('5')">5</button>
                    <button type="button" onclick="appendToDisplay('6')">6</button>

                    <button type="button" onclick="appendToDisplay('1')">1</button>
                    <button type="button" onclick="appendToDisplay('2')">2</button>
                    <button type="button" onclick="appendToDisplay('3')">3</button>
                    <button type="button" onclick="appendToDisplay('0')">0</button>
                    <button type="button" onclick="appendToDisplay('.')">.</button>
                </div>

                <div class="action-buttons">
                    <button type="submit">Вычислить</button>
                    <button type="reset">Очистить</button>
                </div>
            </form>

            <?php
            function evaluateExpression($expression) {
                $expression = str_replace(' ', '', $expression);
                $expression = str_replace('×', '*', $expression);

                $result = eval("return $expression;");
                return $result;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["output"])) {
                    $expression = $_POST["output"];
                    $result = evaluateExpression($expression);

                    echo "<div class='result'>Результат: $expression = $result</div>";

                    $historyFile = 'calculator_history.txt';
                    $historyData = date('Y.m.d H:i:s') . " - $expression = $result\n";
                    file_put_contents($historyFile, $historyData, FILE_APPEND | LOCK_EX);
                }
            }
            ?>

            <h3>История операций</h3>
            <?php
            if (file_exists('calculator_history.txt')) {
                $history = file_get_contents('calculator_history.txt');
                echo "<pre>$history</pre>";
            } else {
                echo "История операций пуста.";
            }
            ?>
        </div>
    </div>
</div>

<script>
    function appendToDisplay(value) {
        const display = document.getElementById('output');
        display.value += value;
    }
    function calculate() {
        const display = document.getElementById('output');
        const expression = display.value.replace(/×/g, '*');
        display.value = eval(expression);
    }
</script>

</body>
</html>