<?php

$exportResult = "";
$currentValue = "";

function minMaxSum($arr)
{
    $sum = $arr[0];
    $min = $arr[0];
    $max = $arr[0];

    $arrlength = count($arr);
    $newArray = [];
    for ($i = 0; $i < $arrlength; $i++) {
        $currentArray = $arr;
        unset($currentArray[$i]);
        array_push($newArray, array_sum($currentArray));
    }

    return [min($newArray), max($newArray)];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST['inputArr'];
    $array = explode(' ', $input);
    $array = array_map('intval', $array);

    if (count($array) <> 5) {
        $alert = "Incorrect Array Input";
        $exportResult = "";
    } else {
        $result = minMaxSum($array);
        $exportResult = "$result[0]  $result[1]";
    }
    $currentValue = $input;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Waizly Basic - Test 1</title>
</head>

<body>
    <div class="container">
        <h2>Waizly - Problem Solving Basic - Test 1</h2>
        <?php if (isset($alert)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $alert ?>
        </div>
        <?php } ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Give 5 input array, with space-separated for example : <strong>1 3 5 7 9</strong></label>
                <input type="text" class="form-control" id="inputArr" name="inputArr" value="<?= $currentValue ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="mt-3">
            <input type="text" class="form-control" value="<?= $exportResult ?>" disabled>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>

</html>