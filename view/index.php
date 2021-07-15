<?php


include __DIR__ . "/Parse.php";
$parse = new Parse();

if (isset($_POST["detail"])) {
    $normalizedArray = $parse->getNormalizedArray($_POST["detail"]);

}
$normalizedArray = $parse->getNormalizedArray("rx-bits-per-second");
?>
<html lang="tr">
<head>
    <title>mrJavaci/mikrotik-graph</title>
    <script>
        window.onload = function () {
            var ctx = document.getElementById('myChart');
            const labels = <?php echo json_encode($normalizedArray["labels"]);?>

            const data = {
                labels: labels,
                datasets: [{
                    label: 'My First Dataset',
                    data: <?php echo json_encode($normalizedArray["values"]);?>,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            };
            var myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return bytesToSize(value);
                                }
                            }
                        }
                    }
                }
            });
        }
        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Byte';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }
    </script>
</head>
<body>
<form action="" method="post">

    <select name="detail" id="cars">
        <?php
        foreach ($parse->getDetailNames() as $detailName) {
            ?>
            <option value="<?= $detailName ?>"><?= $detailName ?></option>

            <?php

        }
        ?>
    </select>
    <input type="submit" value="Submit">

</form>
<canvas id="myChart" width="400" height="400"></canvas>

<script src="../node_modules/chart.js/dist/chart.js"></script>

</body>

</html>

