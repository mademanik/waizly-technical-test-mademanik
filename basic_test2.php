<?php

$currentArrLength = "";
$currentArrrayInput = "";
$result = [];
function plusMinus($arrLength, $array)
{
    $countPositiveNumber = 0;
    $countNegativeNumber = 0;
    $countZeroNumber = 0;

    for ($i = 0; $i < $arrLength; $i++) {
        if ($array[$i] > 0) $countPositiveNumber += 1;
        if ($array[$i] < 0) $countNegativeNumber += 1;
        if ($array[$i] == 0) $countZeroNumber += 1;
    }

    $resultArr = [];
    array_push(
        $resultArr,
        number_format($countPositiveNumber / $arrLength, 6),
        number_format($countNegativeNumber / $arrLength, 6),
        number_format($countZeroNumber / $arrLength, 6)
    );

    return $resultArr;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arrLength = $_POST['arrLength'];
    $inputArr = $_POST['inputArr'];
    $array = explode(' ', $inputArr);
    $array = array_map('intval', $array);

    if (count($array) <> $arrLength) {
        $alert = "Inconsistency Input Array : " . count($array) . ", and Size of n : $arrLength";
    } else {
        $result = plusMinus($arrLength, $array);
    }

    $currentArrLength = $arrLength;
    $currentArrrayInput = $inputArr;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Waizly Basic - Test 2</title>
</head>

<body>
    <div class="container">
        <h2>Waizly - Problem Solving Basic - Test 2</h2>
        <?php if (isset($alert)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $alert ?>
        </div>
        <?php } ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Size of n</label>
                <input type="text" class="form-control" id="arrLength" name="arrLength" value="<?= $currentArrLength ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Input Array with space-separated</label>
                <input type="text" class="form-control" id="inputArr" name="inputArr" value="<?= $currentArrrayInput ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="mt-3">
            <?php foreach ($result as $res) {  ?>
            <input type="text" class="form-control mt-2" value="<?= $res ?>" disabled>
            <?php } ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>

</html>