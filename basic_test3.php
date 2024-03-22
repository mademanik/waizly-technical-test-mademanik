<?php

$result = "";
$currentTimeInput = "";
function timeConversion($timeStrInput)
{
    return date("H:i:s", strtotime($timeStrInput));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input12HourTimeFormat = $_POST['timeInput'];
    $result = timeConversion($input12HourTimeFormat);
    $currentTimeInput = $input12HourTimeFormat;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Waizly Basic - Test 3</title>
</head>

<body>
    <div class="container">
        <h2>Waizly - Problem Solving Basic - Test 3</h2>
        <?php if (isset($alert)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $alert ?>
        </div>
        <?php } ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Time Input</label>
                <input type="text" class="form-control" id="timeInput" name="timeInput" value="<?= $currentTimeInput ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="mt-3">
            <input type="text" class="form-control mt-2" value="<?= $result ?>" disabled>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>

</html>